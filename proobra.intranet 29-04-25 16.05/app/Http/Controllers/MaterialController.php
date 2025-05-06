<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $material->update([
            'descripcion' => $request->input('descripcion'),
            'cantidad_unidades' => $request->input('cantidad_unidades'),
            'costo_unitario' => $request->input('costo_unitario'),
            'manos' => $request->input('manos'),
            'rendimiento' => $request->input('rendimiento'),
            'litros_por_lata' => $request->input('litros_por_lata'),
        ]);

        return back()->with('success', 'Material actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'replanteo_id' => 'required|exists:replanteos,id',
        ]);

        $material = Material::create([
            'replanteo_id' => $request->replanteo_id,
            'descripcion' => '',
            'cantidad_unidades' => 0,
            'costo_unitario' => 0,
            'manos' => 1,
            'rendimiento' => null,
            'litros_por_lata' => null,
        ]);

        $html = view('partials.fila_material', compact('material'))->render();

        return response()->json(['nuevaFilaHtml' => $html]);
    }

}
