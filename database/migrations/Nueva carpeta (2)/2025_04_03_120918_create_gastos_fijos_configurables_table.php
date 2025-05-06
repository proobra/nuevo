<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gastos_fijos_configurables', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('valor', 12, 2)->default(0);
            $table->string('tipo')->default('monto'); // 'monto' o 'porcentaje'
            $table->boolean('editable')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos_fijos_configurables');
    }
};