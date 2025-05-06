<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PresupuestoCosto extends Model
{
    protected $table = 'presupuesto_costos';

    protected $fillable = [
        'presupuesto_id',
        'categoria',
        'concepto',
        'monto',
    ];

    public function presupuesto(): BelongsTo
    {
        return $this->belongsTo(Presupuesto::class);
    }
}