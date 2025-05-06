<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained()->onDelete('cascade');
            $table->foreignId('replanteo_id')->nullable()->constrained('replanteos')->onDelete('cascade');
            $table->string('descripcion')->nullable();
            $table->decimal('cantidad_unidades', 10, 2)->nullable();
            $table->decimal('costo_unitario', 10, 2)->nullable();
            $table->decimal('manos', 10, 2)->nullable();
            $table->decimal('rendimiento', 10, 2)->nullable();
            $table->decimal('litros_por_lata', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('materiales');
    }
};
