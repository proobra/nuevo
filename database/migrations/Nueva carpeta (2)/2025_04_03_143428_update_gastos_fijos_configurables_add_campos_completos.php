<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gastos_fijos_configurables', function (Blueprint $table) {
            if (!Schema::hasColumn('gastos_fijos_configurables', 'nombre')) {
                $table->string('nombre')->after('id');
            }

            if (!Schema::hasColumn('gastos_fijos_configurables', 'tipo')) {
                $table->string('tipo')->default('monto');
            }

            if (!Schema::hasColumn('gastos_fijos_configurables', 'valor')) {
                $table->decimal('valor', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('gastos_fijos_configurables', 'editable')) {
                $table->boolean('editable')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('gastos_fijos_configurables', function (Blueprint $table) {
            if (Schema::hasColumn('gastos_fijos_configurables', 'nombre')) {
                $table->dropColumn('nombre');
            }
            if (Schema::hasColumn('gastos_fijos_configurables', 'tipo')) {
                $table->dropColumn('tipo');
            }
            if (Schema::hasColumn('gastos_fijos_configurables', 'valor')) {
                $table->dropColumn('valor');
            }
            if (Schema::hasColumn('gastos_fijos_configurables', 'editable')) {
                $table->dropColumn('editable');
            }
        });
    }
};
