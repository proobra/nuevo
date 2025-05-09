<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\ReplanteoTarea;
use App\Models\Material;
use App\Models\ManoDeObra;

class PresupuestoDetalleController extends Controller
{
    public function show($id)
{
    $presupuesto = Presupuesto::with([
        'replanteos',
        'replanteos.materiales',
        'replanteos.manoDeObra',
        'materiales',
        'mano_obra' // si usás mano_obra como relación directa
    ])->findOrFail($id);

    $total_mano_obra = $presupuesto->replanteos->sum('total_mano_obra');
    $total_materiales = $presupuesto->replanteos->sum('total_materiales');
    $gastos_fijos = 0;
    $subtotal = $total_mano_obra + $total_materiales + $gastos_fijos;

    $iva = $subtotal * 0.22;
    $bps = $total_mano_obra * 0.185;
    $total_final = $subtotal + $iva + $bps;

    return view('presupuestos.detalle', compact(
        'presupuesto',
        'total_mano_obra',
        'total_materiales',
        'gastos_fijos',
        'subtotal',
        'iva',
        'bps',
        'total_final'
    ));
}


    public function storeCostos(Request $request, $presupuestoId)
    {
        $presupuesto = Presupuesto::findOrFail($presupuestoId);

        // 1. Actualizar datos del presupuesto
        $presupuesto->update($request->only([
            'fecha', 'titulo', 'empresa', 'cliente', 'telefono', 'email', 'direccion', 'utilidad'
        ]));

        // 2. Eliminar anteriores
        $presupuesto->replanteos()->delete();

        // 3. Replanteo
        $replanteoIds = $request->input('replanteo_id', []);
        $replanteoDescripciones = $request->input('replanteo_descripcion', []);
        $replanteoM2 = $request->input('replanteo_metros2', []);
        $replanteoDias = $request->input('replanteo_dias', []);
        $replanteoObs = $request->input('replanteo_observaciones', []);

        $replanteosCreados = [];

        foreach ($replanteoDescripciones as $i => $desc) {
            $replanteosCreados[$i] = $presupuesto->replanteos()->create([
                'orden' => $replanteoIds[$i] ?? ($i + 1),
                'descripcion_tarea' => $desc,
                'metros2' => $replanteoM2[$i] ?? 0,
                'dias' => $replanteoDias[$i] ?? 0,
                'observaciones' => $replanteoObs[$i] ?? ''
            ]);
        }

        // 4. Mano de Obra
        $obraIds = $request->input('obra_id_tarea', []);
        foreach ($obraIds as $i => $idTarea) {
            if (!empty($idTarea) && isset($replanteosCreados[$idTarea - 1])) {
                $replanteosCreados[$idTarea - 1]->manoDeObra()->create([
                    'categoria' => $request->obra_categoria[$i] ?? '',
                    'cantidad' => $request->obra_cantidad[$i] ?? 0,
                    'comentario' => $request->obra_comentario[$i] ?? '',
                    'dias' => $request->obra_dias[$i] ?? 0,
                ]);
            }
        }

        // 5. Materiales
        $nombres           = $request->input('material_nombre', []);
        $idTareasMaterial  = $request->input('material_id_tarea', []);
        $cantidades        = $request->input('material_cantidad', []);
        $costosUnitarios   = $request->input('material_costo_unitario', []);
        $manos             = $request->input('material_manos', []);
        $rendimientos      = $request->input('material_rendimiento', []);

        foreach ($nombres as $i => $nombre) {
            if (!empty($nombre) && isset($replanteosCreados[$idTareasMaterial[$i] - 1])) {
                $replanteosCreados[$idTareasMaterial[$i] - 1]->materiales()->create([
                    'descripcion'         => $nombre,
                    'cantidad'       => $cantidades[$i] ?? 0,
                    'costo_unitario' => $costosUnitarios[$i] ?? 0,
                    'manos'          => $manos[$i] ?? 1,
                    'rendimiento'    => $rendimientos[$i] ?? 0,
                ]);
            }
        }

        return back()->with('success', 'Presupuesto guardado correctamente.');
    }
}
