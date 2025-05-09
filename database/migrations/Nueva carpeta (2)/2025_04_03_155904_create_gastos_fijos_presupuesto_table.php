<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gastos_fijos_presupuesto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('presupuesto_id');
            $table->unsignedBigInteger('gasto_fijo_id');

            $table->decimal('cantidad_ml', 10, 2)->nullable(); // solo para IMM
            $table->decimal('valor_aplicado', 12, 2)->nullable(); // opcional: se puede calcular

            $table->timestamps();

            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade');
            $table->foreign('gasto_fijo_id')->references('id')->on('gastos_fijos_configurables')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos_fijos_presupuesto');
    }
};

