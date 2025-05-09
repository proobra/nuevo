<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('gastos_fijos_configurables', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['porcentaje', 'monto'])->default('monto');
            $table->decimal('valor', 10, 2)->default(0);
            $table->boolean('editable')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('gastos_fijos_configurables');
    }
};
