<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replanteos extends Model
{
    use HasFactory;

    protected $table = 'replanteos';

    protected $fillable = [
        'presupuesto_id',
        'descripcion_tarea',
        'm2',
        'dias',
        'observaciones',
    ];
}
