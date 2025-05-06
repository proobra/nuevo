<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;

class ReplanteoController extends Controller
{
    public function index($presupuesto_id)
    {
        $presupuesto = Presupuesto::with('replanteos')->findOrFail($presupuesto_id);
        $replanteos = $presupuesto->replanteos;
        return view('replanteo.index', compact('replanteos', 'presupuesto'));
    }
}
