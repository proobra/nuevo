<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Replanteo;
use App\Models\Material;
use Illuminate\Support\Facades\Log;
use App\Models\GastoFijoPresupuesto;
use App\Models\LaudosOperarios;
use App\Models\ManoDeObra;
use App\Services\PresupuestoCalculador;

class PresupuestoController extends Controller
{




    // formulario de busqueda por id direccion etc
    public function buscar(Request $request)
    {
        $query = $request->input('q');

        dd($request->only(['subtotal_materiales','subtotal_mano_obra']));


        $presupuestos = Presupuesto::where('id', 'LIKE', "%$query%")
            ->orWhere('titulo', 'LIKE', "%$query%")
            ->orWhere('direccion', 'LIKE', "%$query%")
            ->orWhere('cliente', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->orWhere('telefono', 'LIKE', "%$query%")
            ->orderBy('id', 'desc')
            ->get();

        return view('presupuestos.index', compact('presupuestos', 'query'));
    }


      public function create()
  {
    $presupuesto = new Presupuesto();
    $presupuesto->replanteos = collect();
    $presupuesto->manoDeObra = collect();
    $presupuesto->materiales = collect();

    return view('presupuestos.edit', compact('presupuesto'));
 }


 public function store(Request $request)
 {
     // Validación básica
     $request->validate([
         'titulo' => 'nullable|string|max:255', // lo hacemos opcional, lo completamos abajo
     ]);

     // Título inteligente: si no viene, lo armamos
     $titulo = $request->input('titulo')
         ?: ($request->input('presupuesto_padre_id')
             ? 'Presupuesto hijo de ' . $request->input('presupuesto_padre_id')
             : 'nuevo presupuesto');

     // Crear el presupuesto
     $presupuesto = Presupuesto::create([
         'presupuesto_padre_id' => $request->input('presupuesto_padre_id'),
         'cliente' => $request->input('cliente'),
         'empresa' => $request->input('empresa'),
         'direccion' => $request->input('direccion'),
         'telefono' => $request->input('telefono'),
         'email' => $request->input('email'),
         'fecha' => now(),
         'fecha_inicio' => now(),
         'duracion_dias' => $request->input('duracion_dias') ?? 0,
         'titulo' => $titulo,
         'titulo_caratula' => $request->input('titulo_caratula') ?? '',
         'descripcion' => $request->input('descripcion') ?? '',
         'utilidad' => $request->input('utilidad') ?? 0,
         'bps_porcentaje' => $request->input('bps_porcentaje') ?? 0,

         'superficie' => $request->input('superficie') ?? 0,
         'caratula' => $request->input('caratula') ?? '',
     ]);

     // Guardar REPLANTEO (si lo hay)
     if ($request->has('replanteo_descripcion')) {
         foreach ($request->input('replanteo_descripcion') as $i => $descripcion) {
             $presupuesto->replanteos()->create([
                 'orden' => $request->input('replanteo_orden')[$i] ?? ($i + 1),
                 'descripcion_tarea' => $descripcion,
                 'm2' => $request->input('replanteo_metros2')[$i] ?? 0,
                 'dias' => $request->input('replanteo_dias')[$i] ?? 0,
                 'observaciones' => $request->input('replanteo_observaciones')[$i] ?? '',
             ]);
         }
     }

     // Guardar MATERIALES (si los hay)
     if ($request->has('materiales')) {
         foreach ($request->input('materiales') as $material) {
             $presupuesto->materiales()->create([
                 'orden' => $material['orden'] ?? 1,
                 'descripcion' => $material['descripcion'] ?? '',
                 'cantidad_unidades' => $material['cantidad_unidades'] ?? 0,
                 'manos' => $material['manos'] ?? 0,
                 'rendimiento' => $material['rendimiento'] ?? 1,
                 'litros_por_lata' => $material['litros_por_lata'] ?? 1,
                 'costo_unitario' => $material['costo_unitario'] ?? 0,
             ]);
         }
     }

     // Guardar MANO DE OBRA (si la hay)
     if ($request->has('obra_categoria')) {
         foreach ($request->input('obra_categoria') as $i => $categoria) {
             $presupuesto->manoDeObra()->create([
                 'categoria' => $categoria,
                 'cantidad' => $request->input('obra_cantidad')[$i] ?? 0,
                 'dias' => $request->input('obra_dias')[$i] ?? 0,
                 'valor_jornal' => $request->input('obra_valor_jornal')[$i] ?? 0,
                 'replanteo_id' => null,
                 'orden' => $request->input('obra_id_tarea')[$i] ?? 1,
             ]);
         }
     }

     return redirect()->route('presupuestos.edit', $presupuesto->id)
                      ->with('success', 'Presupuesto creado correctamente.');
 }





    public function update(Request $request, $id)
    {

        $presupuesto = Presupuesto::findOrFail($id);

              // 🟰 Primero guardar los subtotales ocultos (hidden inputs)
              $presupuesto->subtotal_mano_obra = $request->input('subtotal_mano_obra', 0);
              $presupuesto->subtotal_materiales = $request->input('subtotal_materiales', 0);
              $presupuesto->subtotal_gastos_fijos = $request->input('subtotal_gastos_fijos', 0);
              $presupuesto->utilidad_monto = $request->input('utilidad_monto', 0);
              $presupuesto->subtotal_general = $request->input('subtotal_general', 0);
              $presupuesto->iva_monto = $request->input('iva_monto', 0);
              $presupuesto->bps_monto = $request->input('bps_monto', 0);
              $presupuesto->total_final = $request->input('total_final', 0);
                $presupuesto->precio_por_m2 = $request->input('precio_por_m2', 0);
                $presupuesto->porcentaje_utilidad_sobre_costos = $request->input('porcentaje_utilidad_sobre_costos', 0);
                $presupuesto->porcentaje_utilidad = $request->input('porcentaje_utilidad', 0);



    // 🛠️ Luego seguir con actualizar los datos generales (empresa, cliente, etc.)
    $presupuesto->empresa = $request->empresa;
    $presupuesto->cliente = $request->cliente;
    $presupuesto->telefono = $request->telefono;
    $presupuesto->email = $request->email;
    $presupuesto->direccion = $request->direccion;
    $presupuesto->titulo = $request->titulo;
    $presupuesto->titulo_caratula = $request->titulo_caratula;
    $presupuesto->fecha = $request->fecha;
    $presupuesto->superficie = $request->superficie ?? 0;
    $presupuesto->utilidad = $request->utilidad ?? 0;
    $presupuesto->bps_porcentaje = $request->bps_porcentaje ?? 0;

    $presupuesto->save();

        // 1. Actualizar datos generales
        $presupuesto->update([
            'cliente' => $request->input('cliente'),
            'empresa' => $request->input('empresa'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
            'email' => $request->input('email'),
            'fecha' => $request->input('fecha') ?? now(),
            'fecha_inicio' => $request->input('fecha_inicio') ?? now(),
            'duracion_dias' => $request->input('duracion_dias') ?? 0,
            'titulo' => $request->input('titulo') ?: 'nuevo presupuesto',
            'titulo_caratula' => $request->input('titulo_caratula'),
            'descripcion' => $request->input('descripcion') ?? '',
            'utilidad' => $request->input('utilidad') ?? 0,
            'bps_porcentaje' => $request->input('bps_porcentaje') ?? 73,


            'superficie' => $request->input('superficie') ?? 0,
            // otros campos si tenés...
        ]);

        // 2. Guardar o actualizar replanteos
        $descripciones = $request->input('replanteo_descripcion', []);
        $ids = $request->input('replanteo_id', []);
        $eliminados = $request->input('replanteo_eliminar', []);
        $replanteoIds = [];

        foreach ($descripciones as $i => $descripcion) {
            // Si la fila fue marcada para eliminar
            if (isset($eliminados[$i]) && $eliminados[$i] == 1) {
                if (!empty($ids[$i])) {
                    \App\Models\Replanteo::destroy($ids[$i]);
                }
                continue;
            }

            // Crear o actualizar
            if (!empty($descripcion)) {
                $replanteo = $presupuesto->replanteos()->updateOrCreate(
                    ['id' => $ids[$i] ?? null],
                    [
                        'presupuesto_id' => $presupuesto->id,
                        'descripcion_tarea' => $descripcion,
                        'm2'                => $request->input('replanteo_metros2')[$i] ?? 0,
                        'dias'              => $request->input('replanteo_dias')[$i] ?? 0,
                        'observaciones'     => $request->input('replanteo_observaciones')[$i] ?? '',
                        'orden'             => $i + 1,
                    ]
                );
                $replanteoIds[$i] = $replanteo->id;
            }
        }






        // Asegurar que exista el replanteo con orden 1
if ($request->has('obra_comentario')) {
    foreach ($request->obra_comentario as $i => $fila) {
        // 👉 Manejar eliminación
        if (!empty($fila['eliminar']) && $fila['eliminar'] == 1 && !empty($fila['id'])) {
            \App\Models\ManoDeObra::destroy($fila['id']);
            continue;
        }

        // 1. Obtener el número de orden ingresado
        $ordenIngresado = $request->input('obra_id_tarea')[$i] ?? 1;

        // 2. Buscar o crear automáticamente el Replanteo para ese orden
        $replanteo = \App\Models\Replanteo::where('orden', $ordenIngresado)
    ->where('presupuesto_id', $presupuesto->id)
    ->first();

if (!$replanteo) {
    continue; // NO crear nada si no existe
}



        // 3. Guardar Mano de Obra apuntando al ID real del Replanteo
        $presupuesto->manoDeObra()->updateOrCreate(
            ['id' => @$request->input('obra_id')[$i]],
            [
                'presupuesto_id' => $presupuesto->id,
                'replanteo_id'   => $replanteo->id, // 👈 El id real encontrado/creado
                'orden'          => $ordenIngresado,
                'comentario'     => @$request->input('obra_comentario')[$i],
                'categoria'      => @$request->input('obra_categoria')[$i],
                'cantidad'       => @$request->input('obra_cantidad')[$i],
                'dias'           => @$request->input('obra_dias')[$i],
                'valor_jornal'   => @$request->input('obra_valor_jornal')[$i],
            ]
        );
    }
}





         // Guardar gastos fijos
        $gastosFijosSeleccionados = $request->input('gastos_fijos', []);
      //  $gastosFijos = $request->input('gastos_fijos', []);
      //  $presupuesto->gastos_fijos = json_encode($gastosFijos);
     //   $presupuesto->save();



        // 4. Guardar Materiales (secuencial)
        foreach ($request->materiales as $material) {
            if (isset($material['eliminar']) && $material['eliminar'] == 1) {
                if (!empty($material['id'])) {
                    Material::destroy($material['id']);
                }
                continue;
            }

            // ⚠️ Validar si existe el replanteo
            $replanteo = \App\Models\Replanteo::where('orden', $material['orden'] ?? 1)
                ->where('presupuesto_id', $presupuesto->id)
                ->first();

            if (!$replanteo) {
                continue; // Si no existe el replanteo, NO guardar este material
            }
        \Log::info('material',[$material]);
            Material::updateOrCreate(
                ['id' => @$material['id']],
                [
                    'presupuesto_id' => $presupuesto->id,
                    'descripcion' => $material['descripcion'],
                    'orden' => $material['orden'],
                    'cantidad_unidades' => $material['cantidad_unidades'],
                    'costo_unitario' => $material['costo_unitario'],
                    'manos' => $material['manos'],
                    'rendimiento' => $material['rendimiento'],
                    'litros_por_lata' => $material['litros_por_lata'],
                ]
            );
        }



        if ($request->has('gasto_fijo_id')) {
            foreach ($request->gasto_fijo_id as $index => $gastoId) {
                $seleccionado = in_array($gastoId, $request->gasto_seleccionado ?? []);
                $cantidad = $request->gasto_cantidad[$index] ?? null;
                $valor = $request->gasto_valor[$index] ?? null;

                if ($seleccionado) {
                    GastoFijoPresupuesto::updateOrCreate(
                        [
                            'presupuesto_id' => $presupuesto->id,
                            'gasto_fijo_id' => $gastoId,
                        ],
                        [
                            'cantidad_ml' => $cantidad,
                            'valor_aplicado' => $valor,
                        ]
                    );
                } else {
                    GastoFijoPresupuesto::where('presupuesto_id', $presupuesto->id)
                        ->where('gasto_fijo_id', $gastoId)
                        ->delete();
                }
            }
        }



                        // Guarda para inforem tecnico
// Al final del método update(), antes del return redirect():
// 🔥 Cálculo de subtotales y totales para guardar en el presupuesto

$subtotalManoObra = 0;
foreach ($presupuesto->manoDeObra as $mo) {
    $subtotalManoObra += ($mo->valor_jornal ?? 0) * ($mo->cantidad ?? 0) * ($mo->dias ?? 0);
}

$subtotalMateriales = 0;
foreach ($presupuesto->materiales as $material) {
    $unidades = $material->cantidad_unidades ?? 0;
    $costo = $material->costo_unitario ?? 0;
    $subtotalMateriales += $unidades * $costo;
}

$subtotalGastosFijos = 0;
foreach ($presupuesto->gastosFijos as $gasto) {
    $subtotalGastosFijos += ($gasto->valor_aplicado ?? 0) * ($gasto->cantidad_ml ?? 1);
}

$porcentajeUtilidad = $presupuesto->utilidad ?? 0;
$utilidadMonto = $subtotalManoObra * ($porcentajeUtilidad / 100);

$subtotalGeneral = $subtotalManoObra + $subtotalMateriales + $subtotalGastosFijos + $utilidadMonto;

$iva = 0;
$ivaActivo = $presupuesto->gastosFijos->contains('gasto_fijo_id', 1); // Verificamos si el IVA está activo
if ($ivaActivo) {
    $iva = $subtotalGeneral * 0.22;
}

$bpsPorcentaje = $presupuesto->bps_porcentaje ?? 0;
$bps = $subtotalManoObra * ($bpsPorcentaje / 100);

$totalFinal = $subtotalGeneral + $iva + $bps;

// 🔵 Ahora sí actualizamos el presupuesto
$presupuesto->update([
    'subtotal_mano_obra' => $subtotalManoObra,
    'subtotal_materiales' => $subtotalMateriales,
    'subtotal_gastos_fijos' => $subtotalGastosFijos,
    'utilidad_monto' => $utilidadMonto,
    'subtotal_general' => $subtotalGeneral,
    'iva_monto' => $iva,
    'bps_monto' => $bps,
    'total_final' => $totalFinal,
]);








        return redirect()->route('presupuestos.edit', $presupuesto->id)
                         ->with('success', 'Presupuesto guardado correctamente.');
    }




    public function edit($id)
{

    //Carga el Pdre
    $presupuesto = Presupuesto::with('replanteos', 'materiales', 'replanteos.materiales', 'replanteos.manoDeObra', 'manoDeObra.replanteo')
                              ->findOrFail($id);
    //Carga el Hijo
    $presupuesto->load('hijos'); // carga los presupuestos hijos del padre
     $laudos = \App\Models\LaudoOperario::orderBy('orden')->get();
     $laudosMap = $laudos->keyBy('categoria');


     // Cargar valores de jornal para cada registro de mano de obra
     $presupuesto->manoDeObra->transform(function ($item) use ($laudosMap) {
        // Si ya tiene valor_jornal guardado, no lo pises
        if (!$item->valor_jornal || $item->valor_jornal == 0) {
            $categoria = $item->categoria;
            $item->valor_jornal = $laudosMap[$categoria]->total_jornal ?? 0;
        }

        $item->total = $item->cantidad * $item->dias * $item->valor_jornal;
        return $item;
    });


     $gastosFijos = \App\Models\GastoFijoConfigurable::all();
     $presupuesto->load('gastosFijos');

    // dd($presupuesto->hijos);


// Calcular precios por M2 para el replanteo
$preciosPorM2 = [];
foreach ($presupuesto->replanteos as $tarea) {
    $m2 = $tarea->m2 ?? 0;

    $materialesTarea = $presupuesto->materiales->where('orden', $tarea->orden);
    $manoObraTarea = $presupuesto->manoDeObra->where('orden', $tarea->orden);

    $subtotalMateriales = $materialesTarea->sum(function($mat) {
        return ($mat->cantidad_unidades ?? 0) * ($mat->costo_unitario ?? 0);
    });

    $subtotalManoDeObra = $manoObraTarea->sum(function($mo) {
        return ($mo->cantidad ?? 0) * ($mo->dias ?? 0) * ($mo->valor_jornal ?? 0);
    });

    $totalCosto = $subtotalMateriales + $subtotalManoDeObra;
    $precioPorM2 = ($m2 > 0) ? $totalCosto / $m2 : 0;

    $preciosPorM2[$tarea->orden] = $precioPorM2;
}

     return view('presupuestos.edit', compact('presupuesto', 'gastosFijos', 'laudos','preciosPorM2' ));
}



    public function detalle($id)
    {
        $presupuesto = Presupuesto::with('replanteos', 'materiales', 'replanteos.materiales', 'replanteos.manoDeObra')
                                  ->findOrFail($id);

        return view('presupuestos.detalle', compact('presupuesto'));
    }

    public function guardarCostos(Request $request, $id)
    {
        $presupuesto = Presupuesto::findOrFail($id);

        // Replanteo
        if ($request->has('replanteo_id')) {
            foreach ($request->replanteo_id as $i => $replanteoId) {
                $presupuesto->replanteos()->updateOrCreate(
                    ['id' => $replanteoId],
                    [
                        'descripcion_tareas' => $request->replanteo_descripcion[$i],
                        'm2'            => $request->replanteo_metros2[$i],
                        'dias'          => $request->replanteo_dias[$i],
                        'observaciones' => $request->replanteo_observaciones[$i],
                    ]
                );
            }
        }

        // Mano de obra
        if ($request->has('obra_id_tarea')) {
            foreach ($request->obra_id_tarea as $i => $idTarea) {
                $presupuesto->manoDeObra()->updateOrCreate(
                    [
                        'replanteo_id' => $idTarea,
                        'comentario'   => $request->obra_comentario[$i],
                    ],
                    [
                        'categoria' => $request->obra_categoria[$i],
                        'cantidad'  => $request->obra_cantidad[$i],
                        'dias'      => $request->obra_dias[$i],
                    ]
                );
            }
        }

        // Materiales
        if ($request->has('material_id_tarea')) {
            foreach ($request->material_id_tarea as $i => $idTarea) {
                $presupuesto->materiales()->updateOrCreate(
                    [
                        'replanteo_id' => $idTarea,
                        'descripcion'  => $request->material_nombre[$i],
                    ],
                    [
                        'cantidad_unidades' => $request->material_cantidad[$i],
                        'costo_unitario'    => $request->material_costo_unitario[$i],
                        'manos'             => $request->material_manos[$i] ?? 1,
                        'rendimiento'       => $request->material_rendimiento[$i] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('presupuestos.edit', $presupuesto->id)
        ->with('success', 'Costos guardados correctamente.');

    }



public function index()
{
    $presupuestos = Presupuesto::latest()->get(); // Podés cambiar el orden si querés
    return view('presupuestos.index', compact('presupuestos'));
}



// Informe Técnico
public function informeTecnico($id)
{
    $presupuesto = Presupuesto::with(['replanteos', 'materiales', 'manoDeObra'])->findOrFail($id);

   // $preciosPorM2 = PresupuestoCalculador::calcularPrecioM2Replanteo($presupuesto);
// $preciosMaterialesM2 = PresupuestoCalculador::calcularPrecioM2Materiales($presupuesto);

$preciosPorM2 = []; // por ahora dejamos vacío para evitar error
$preciosMaterialesM2 = [];

    $laudos = \App\Models\LaudoOperario::all(); // 🛠 Agregamos esto para que $laudos exista



    // Calcular totales
    $totalMateriales = $presupuesto->materiales->sum(function($material) {
        return ($material->cantidad_unidades ?? 0) * ($material->costo_unitario ?? 0);
    });

    $totalManoDeObra = $presupuesto->manoDeObra->sum(function($mano) {
        return ($mano->cantidad ?? 0) * ($mano->dias ?? 0) * ($mano->valor_jornal ?? 0);
    });

    $totalGastosFijos = 0; // De momento dejamos en 0

    $utilidad = $presupuesto->utilidad ?? 0;
    $subtotal = $totalMateriales + $totalManoDeObra + $totalGastosFijos + $utilidad;
    $iva = $subtotal * 0.22;

    // Sumar el laudo_base por fila (categoría) × cantidad × días
    $totalBaseLaudo = 0;
    foreach ($presupuesto->manoDeObra as $mo) {
        $laudoBase = $laudos->firstWhere('categoria', $mo->categoria)?->laudo_base ?? 0;
        $totalBaseLaudo += ($laudoBase * ($mo->cantidad ?? 0) * ($mo->dias ?? 0));
    }

    $bps = ($totalBaseLaudo * ($presupuesto->bps_porcentaje ?? 0)) / 100;
    $totalFinal = $subtotal + $iva + $bps;



    $preciosPorM2 = [];

foreach ($presupuesto->replanteos as $tarea) {
    $m2 = $tarea->m2 ?? 0;

    $materialesTarea = $presupuesto->materiales->where('orden', $tarea->orden);
    $subtotalMateriales = $materialesTarea->sum(function($mat) {
        return ($mat->cantidad_unidades ?? 0) * ($mat->costo_unitario ?? 0);
    });

    $manoObraTarea = $presupuesto->manoDeObra->where('orden', $tarea->orden);
    $subtotalManoDeObra = $manoObraTarea->sum(function($mo) {
        return ($mo->cantidad ?? 0) * ($mo->dias ?? 0) * ($mo->valor_jornal ?? 0);
    });

    $total = $subtotalMateriales + $subtotalManoDeObra;
    $precioM2 = ($m2 > 0) ? $total / $m2 : 0;

    $preciosPorM2[$tarea->orden] = $precioM2;
}



    return view('presupuestos.informe_tecnico', compact(
        'presupuesto',
        'totalMateriales',
        'totalManoDeObra',
        'totalGastosFijos',
        'utilidad',
        'iva',
        'bps',
        'totalFinal',
        'laudos',
        'preciosPorM2',
        'preciosMaterialesM2' // 💥 Pasamos $laudos a la vista
    ));

    $preciosPorM2 = [];

}



// Marcar como Aceptado
public function marcarAceptado(Request $request, $id)
{
    return redirect()->route('presupuestos.edit', $id)->with('success', 'Presupuesto marcado como aceptado.');
}

// Iniciar Obra
public function iniciarObra(Request $request, $id)
{
    return redirect()->route('presupuestos.edit', $id)->with('success', 'Obra iniciada.');
}

// Crear Presupuesto Hijo
public function crearHijo($id)
{
    $presupuestoPadre = Presupuesto::with(['replanteos', 'materiales', 'manoDeObra'])->findOrFail($id);

    $nuevoPresupuesto = $presupuestoPadre->replicate();
    $nuevoPresupuesto->presupuesto_padre_id = $presupuestoPadre->id;
    $nuevoPresupuesto->save();

    // Copiar materiales
    foreach ($presupuestoPadre->materiales as $material) {
        $nuevoMaterial = $material->replicate();
        $nuevoMaterial->presupuesto_id = $nuevoPresupuesto->id;
        $nuevoMaterial->save();
    }

    // Copiar mano de obra
    foreach ($presupuestoPadre->manoDeObra as $mano) {
        $nuevaMano = $mano->replicate();
        $nuevaMano->presupuesto_id = $nuevoPresupuesto->id;
        $nuevaMano->save();
    }

    foreach ($presupuestoPadre->gastosFijos as $gasto) {
        $nuevoGasto = $gasto->replicate();
        $nuevoGasto->presupuesto_id = $nuevoPresupuesto->id;
        $nuevoGasto->save();
    }
    //copy replanteos
    foreach ($presupuestoPadre->replanteos as $replanteo) {
        $nuevoReplanteo = $replanteo->replicate();
        $nuevoReplanteo->presupuesto_id = $nuevoPresupuesto->id;
        $nuevoReplanteo->save();
    }
    return redirect()->route('presupuestos.edit', $nuevoPresupuesto->id)
                     ->with('success', '✅ Presupuesto hijo creado correctamente.');
}


// Duplicar Presupuesto
public function duplicar(Request $request, $id)
{
    return redirect()->route('presupuestos.edit', $id)->with('success', 'Presupuesto duplicado.');
}

// Pausar Obra
public function pausarObra(Request $request, $id)
{
    return redirect()->route('presupuestos.edit', $id)->with('success', 'Obra pausada.');
}

// Finalizar Obra
public function finalizarObra(Request $request, $id)
{
    return redirect()->route('presupuestos.edit', $id)->with('success', 'Obra finalizada.');
}

// Marcar como En Revisión
public function enRevision(Request $request, $id)
{
    return redirect()->route('presupuestos.edit', $id)->with('success', 'Presupuesto en revisión.');
}


}
