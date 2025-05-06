<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_inicio')->nullable();
            $table->integer('duracion_dias')->nullable();
            $table->string('estado')->nullable(); // 'en_ejecucion', 'aceptada', etc.
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('obras');
    }
};
