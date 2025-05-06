<?php

namespace App\Http\Controllers;

use App\Models\GastoFijoConfigurable;
use Illuminate\Http\Request;

class GastoFijoConfigurableController extends Controller
{
    public function index()
    {
        $gastos = GastoFijoConfigurable::all();
        return view('configuracion.gastos_fijos.index', compact('gastos'));
    }

    public function create()
    {
        return view('configuracion.gastos_fijos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'tipo' => 'required|in:monto,porcentaje',
            'editable' => 'boolean',
        ]);

        GastoFijoConfigurable::create($request->all());

        return redirect()->route('configuracion.gastos-fijos.index')->with('success', 'Gasto fijo creado correctamente.');
    }

    public function edit(GastoFijoConfigurable $gastos_fijo)
{
    return view('configuracion.gastos_fijos.edit', [
        'gasto' => $gastos_fijo
    ]);
}


    
public function update(Request $request, GastoFijoConfigurable $gastos_fijo)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|in:monto,porcentaje',
        'valor' => 'required|numeric',
    ]);

    $gastos_fijo->update([
        'nombre' => $validated['nombre'],
        'tipo' => $validated['tipo'],
        'valor' => $validated['valor'],
        'editable' => $request->has('editable'),
    ]);

    return redirect()->route('configuracion.index')->with('success', 'Gasto fijo actualizado correctamente.');
}


public function destroy(GastoFijoConfigurable $gastos_fijo)
{
    $gastos_fijo->delete();

    return redirect()->route('configuracion.index')->with('success', 'Gasto fijo eliminado correctamente.');
}
}
