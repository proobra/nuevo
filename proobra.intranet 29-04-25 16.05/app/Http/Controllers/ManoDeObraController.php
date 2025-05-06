<?php

namespace App\Http\Controllers;

use App\Models\ManoDeObra;
use Illuminate\Http\Request;

class ManoDeObraController extends Controller
{
    public function update(Request $request, $id)
    {
        $obra = ManoDeObra::findOrFail($id);

        $obra->update([
            'categoria' => $request->input('categoria'),
            'cantidad' => $request->input('cantidad'),
            'dias' => $request->input('dias'),
            'comentario' => $request->input('comentario'),
        ]);

        return back()->with('success', 'Mano de obra actualizada correctamente.');
    }
}
