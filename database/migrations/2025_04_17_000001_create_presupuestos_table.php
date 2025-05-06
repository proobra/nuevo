<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('caratula')->nullable();
            $table->string('empresa')->nullable();
            $table->string('cliente')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->decimal('superficie', 10, 2)->nullable();
            $table->decimal('utilidad', 5, 2)->default(0);
            $table->decimal('bps_porcentaje', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('presupuestos');
    }
};
