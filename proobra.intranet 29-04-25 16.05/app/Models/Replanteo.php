<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replanteo extends Model
{
    use HasFactory;

    protected $table = 'replanteos'; // Por claridad (opcional si seguís convención)

    protected $fillable = [
        'presupuesto_id',
        'descripcion_tarea',
        'orden',
        'dias',
        'm2',
        'observaciones',
    ];

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }

    public function materiales()
    {
        return $this->hasMany(Material::class, 'replanteo_id');
    }

    public function manoDeObra()
    {
        return $this->hasMany(ManoDeObra::class, 'replanteo_id');
    }
}
