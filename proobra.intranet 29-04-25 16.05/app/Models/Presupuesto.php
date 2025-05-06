<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use App\Models\ManoDeObra;
use App\Models\Replanteo;

class Presupuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_nombre',
        'descripcion',
        'fecha_inicio',
        'duracion_dias',
        'fecha',
        'titulo',
        'empresa',
        'cliente',
        'contacto',
        'direccion',
        'telefono',
        'email',
        'superficie',
        'utilidad',
        'bps_porcentaje',
        'titulo_caratula',
        'comentarios',
        'presupuesto_padre_id',
    ];

    public function replanteos()
    {
        return $this->hasMany(Replanteo::class)->orderBy('orden');
    }

    public function costos()
    {
        return $this->hasMany(PresupuestoCosto::class);
    }

    public function materiales()
    {
        return $this->hasMany(Material::class, 'presupuesto_id');
    }

   // Relación con mano de obra
public function manoDeObra()
{
    return $this->hasMany(\App\Models\ManoDeObra::class, 'presupuesto_id');
}


    public function totalMateriales()
    {
        return $this->replanteos->sum(function ($r) {
            return $r->total_materiales ?? 0;
        });
    }

 /*   public function totalManoDeObra()
    {
        return $this->replanteos->sum(function ($r) {
            return $r->total_mano_obra ?? 0;
        });
    }    */

    public function gastosFijos()
{
    return $this->hasMany(\App\Models\GastoFijoPresupuesto::class);
}

public function padre()
{
    return $this->belongsTo(Presupuesto::class, 'presupuesto_padre_id');
}

public function hijos()
{
    return $this->hasMany(Presupuesto::class, 'presupuesto_padre_id');
}


}