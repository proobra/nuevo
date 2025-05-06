<?php

namespace App\Http\Controllers;

use App\Models\LaudoOperario;
use Illuminate\Http\Request;

class LaudoOperarioController extends Controller
{
    public function index()
    {
        $laudos = LaudoOperario::all();
        return view('configuracion.laudos.index', compact('laudos'));
    }

    public function store(Request $request)
    {
        LaudoOperario::create($request->all());
        return back()->with('success', 'Laudo agregado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $laudo = LaudoOperario::findOrFail($id);
        $laudo->update($request->all());
        return back()->with('success', 'Laudo actualizado.');
    }

    public function destroy($id)
    {
        LaudoOperario::findOrFail($id)->delete();
        return back()->with('success', 'Laudo eliminado.');
    }
}
