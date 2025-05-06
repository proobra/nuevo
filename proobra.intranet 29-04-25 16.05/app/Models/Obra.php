<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    protected $fillable = [
    'nombre', 'cliente_id', 'fecha_aceptacion', 'fecha_inicio', 'duracion_dias', 'estado'



 ];

}