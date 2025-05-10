<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->decimal('precio_por_m2', 12, 2)->nullable()->after('total_final');
            $table->decimal('porcentaje_utilidad_sobre_costos', 5, 2)->nullable()->after('precio_por_m2');
            $table->decimal('porcentaje_utilidad', 5, 2)->nullable()->after('porcentaje_utilidad_sobre_costos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
};
