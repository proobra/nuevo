<?php

namespace App\Helpers;

use App\Models\Presupuesto;

class PresupuestoCalculador
{
    // Cálculo de precio por m2 para REPLANTEO
    public static function calcularPrecioM2Replanteo(Presupuesto $presupuesto)
    {
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

        return $preciosPorM2;
    }

    // Cálculo de precio por m2 para MATERIALES
    public static function calcularPrecioM2Materiales(Presupuesto $presupuesto)
    {
        $preciosMaterialesM2 = [];

        foreach ($presupuesto->materiales as $material) {
            $cantidad = $material->cantidad_unidades ?? 0;
            $costoUnitario = $material->costo_unitario ?? 0;

            $precioM2Material = $cantidad > 0 ? ($costoUnitario / $cantidad) : 0;
            $preciosMaterialesM2[$material->id] = $precioM2Material;
        }

        return $preciosMaterialesM2;
    }
}
