<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obra;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now();

        $obras = Obra::all()->map(function ($obra) use ($hoy) {
            if ($obra->fecha_inicio) {
                $diasTranscurridos = $hoy->diffInDays($obra->fecha_inicio);
                $diasRestantes = $obra->duracion_dias - $diasTranscurridos;

                if ($diasRestantes <= 0) {
                    $estadoAvance = 'Atrasada';
                } elseif ($diasRestantes <= 3) {
                    $estadoAvance = 'Casi finaliza';
                } else {
                    $estadoAvance = 'En tiempo';
                }
            } else {
                $diasTranscurridos = null;
                $diasRestantes = null;
                $estadoAvance = null;
            }

            $obra->dias_transcurridos = $diasTranscurridos;
            $obra->dias_restantes = $diasRestantes;
            $obra->estado_avance = $estadoAvance;

            return $obra;
        });

        $obrasEnEjecucion = $obras->where('estado', 'en_ejecucion');
        $obrasAceptadas = $obras->where('estado', 'aceptada')->whereNull('fecha_inicio');

        $alertas = [];

        foreach ($obrasEnEjecucion as $obra) {
            if ($obra->dias_restantes !== null && $obra->dias_restantes <= 3) {
                $alertas[] = "La obra \"{$obra->nombre}\" finaliza en {$obra->dias_restantes} días.";
            }
        }

        return view('dashboard', compact('obrasEnEjecucion', 'obrasAceptadas', 'alertas'));
    }
}
