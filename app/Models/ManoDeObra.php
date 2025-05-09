<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManoDeObra extends Model
{
    use HasFactory;

    protected $table = 'mano_de_obra'; // ✅ Nombre real de la tabla en minúsculas

    protected $fillable = [
        'presupuesto_id',
    'replanteo_id',
    'orden',  // 👈 agregamos aquí
    'categoria',
    'cantidad',
    'dias',
    'comentario',
    'valor_jornal',
    ];

    public function replanteo()
    {
        return $this->belongsTo(\App\Models\Replanteo::class, 'replanteo_id');
    }

    public function presupuesto()
{
    return $this->belongsTo(Presupuesto::class);
}
}
