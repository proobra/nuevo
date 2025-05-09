<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaudoOperario extends Model
{
    protected $table = 'laudos_operarios';

    protected $fillable = [
       'categoria', 'valor_jornal', 'orden', 'activo',
    ];
}
