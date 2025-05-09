<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos', 'fecha_inicio')) {
                $table->dateTime('fecha_inicio')->nullable()->after('fecha');
            }
            if (!Schema::hasColumn('presupuestos', 'duracion_dias')) {
                $table->integer('duracion_dias')->default(0)->after('fecha_inicio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio', 'duracion_dias']);
        });
    }
};