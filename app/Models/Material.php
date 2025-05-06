<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materiales'; // importante

    protected $fillable = [
       'presupuesto_id',
        'replanteo_id',
        'descripcion',
        'cantidad_unidades',
        'costo_unitario',
        'manos',
        'rendimiento',
        'litros_por_lata',
        'orden',
    ];

    public function replanteo()
    {
        return $this->belongsTo(Replanteo::class);
    }
    public function presupuesto()
{
    return $this->belongsTo(Presupuesto::class);
}

}
