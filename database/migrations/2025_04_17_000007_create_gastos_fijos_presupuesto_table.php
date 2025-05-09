<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gastos_fijos_presupuesto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained()->onDelete('cascade');
            $table->foreignId('gasto_fijo_id')->constrained('gastos_fijos_configurables')->onDelete('cascade');
            $table->decimal('valor', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('gastos_fijos_presupuesto');
    }
};
