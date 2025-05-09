<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManoDeObra extends Model
{
    use HasFactory;

    protected $table = 'mano_de_obra'; // 👈 ajustalo si el nombre real es distinto

    protected $fillable = [
        'replanteo_id',
        'cantidad',      // cantidad de operarios
        'categoria',     // tipo (peón, oficial, etc.)
        'comentario',
        'dias',
    ];

    public function replanteo()
    {
        return $this->belongsTo(Replanteo::class);
    }
}
