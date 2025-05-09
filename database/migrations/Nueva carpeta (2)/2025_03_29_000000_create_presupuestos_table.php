<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('cliente_nombre');
            $table->text('descripcion');
            $table->date('fecha_inicio');
            $table->integer('duracion_dias');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
};
