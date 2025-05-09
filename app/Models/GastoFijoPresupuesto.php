<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GastoFijoPresupuesto extends Model
{
    protected $table = 'gastos_fijos_presupuesto';

    protected $fillable = [
        'presupuesto_id',
        'gasto_fijo_id',
        'cantidad_ml',
        'valor_aplicado',
    ];
}
