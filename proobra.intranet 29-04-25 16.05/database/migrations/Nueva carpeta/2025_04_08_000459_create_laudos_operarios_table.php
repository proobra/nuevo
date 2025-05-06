<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laudos_operarios', function (Blueprint $table) {
            $table->id();
            $table->string('categoria'); // Ej: Peón, Medio Oficial, etc.
            $table->decimal('laudo', 10, 2)->default(0);
            $table->decimal('desgaste_ropa', 10, 2)->default(0);
            $table->decimal('transporte', 10, 2)->default(0);
            $table->decimal('balancin', 10, 2)->default(0);
            $table->decimal('herramientas', 10, 2)->default(0);
            $table->decimal('alimentos', 10, 2)->default(0);
            $table->decimal('traslados', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laudos_operarios');
    }
};