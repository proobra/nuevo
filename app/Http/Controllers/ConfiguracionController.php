<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GastoFijoConfigurable;
use App\Models\CategoriaOperario;
use App\Models\ConstanteGlobal;
use Illuminate\Support\Facades\DB;
use App\Models\LaudoOperario;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('configuracion.index', [
            'gastosFijos' => GastoFijoConfigurable::all(),
            'categoriasOperarios' => DB::table('categorias_operarios')->get(),
            'constantesGlobales' => DB::table('configuraciones')->get(),
            'laudos' => LaudoOperario::all(), // añadimos los laudos también
        ]);
    }

    public function guardarGastoFijo(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo,constante',
            'valor' => 'required|numeric',
            'unidad' => 'nullable|string|max:10',
        ]);

        GastoFijoConfigurado::updateOrCreate(
            ['id' => $request->id],
            $validated
        );

        return redirect()->route('configuracion.index')->with('success', 'Gasto fijo guardado correctamente.');
    }

    public function eliminarGastoFijo($id)
    {
        GastoFijoConfigurado::destroy($id);
        return redirect()->route('configuracion.index')->with('success', 'Gasto fijo eliminado.');
    }

    public function updateLaudos(Request $request)
    {
        foreach ($request->laudos as $id => $datos) {
            LaudoOperario::where('id', $id)->update($datos);
        }

        return redirect()->route('configuracion.index')->with('success', 'Laudos actualizados correctamente.');
    }
}
