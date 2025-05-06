<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\ReplanteoTarea;

class ReplanteoController extends Controller
{
    public function index($presupuesto_id)
    {
        $presupuesto = Presupuesto::with('replanteos')->findOrFail($presupuesto_id);
        $replanteos = $presupuesto->replanteos;
        return view('replanteo.index', compact('replanteos', 'presupuesto'));
    }

    public function create($presupuesto_id)
    {
        $presupuesto = Presupuesto::findOrFail($presupuesto_id);
        return view('replanteo.create', compact('presupuesto'));
    }

    public function store(Request $request, $presupuesto_id)
    {
        $request->validate([
            'descripcion_tarea' => 'required|string|max:255',
            'orden' => 'required|integer|min:1',
            'dias' => 'nullable|integer|min:0',
            'metros2' => 'nullable|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        Replanteo::create([
            'presupuesto_id' => $presupuesto_id,
            'descripcion_tarea' => $request->descripcion_tarea,
            'orden' => $request->orden,
            'dias' => $request->dias,
            'metros2' => $request->metros2,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('replanteo.index', $presupuesto_id)->with('success', 'Tarea agregada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $tarea = ReplanteoTarea::findOrFail($id);

        $tarea->update([
            'descripcion_tarea' => $request->input('descripcion_tarea'),
            'dias' => $request->input('dias'),
            'metros2' => $request->input('metros2'),
            'observaciones' => $request->input('observaciones'),
        ]);

        return back()->with('success', 'Tarea actualizada correctamente.');
    }
}
