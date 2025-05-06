<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('laudos_operarios', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->string('sector')->default('Construcción');
            $table->decimal('laudo_base', 10, 2)->default(0);
            $table->decimal('desgaste_ropa', 10, 2)->default(0);
            $table->decimal('transporte', 10, 2)->default(0);
            $table->decimal('s_balancin', 10, 2)->default(0);
            $table->decimal('herramientas', 10, 2)->default(0);
            $table->decimal('alimentos', 10, 2)->default(0);
            $table->decimal('presentismo_semanal', 10, 2)->default(0);
            $table->decimal('presentismo_mensual', 10, 2)->default(0);
            $table->decimal('total_jornal', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('laudos_operarios');
    }
};
