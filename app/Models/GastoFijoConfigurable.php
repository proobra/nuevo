<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoFijoConfigurable extends Model
{
    use HasFactory;

    protected $table = 'gastos_fijos_configurables'; //  esta línea soluciona el problema

    protected $fillable = [
        'nombre',
        'valor',
        'tipo',
        'editable',
    ];
}




