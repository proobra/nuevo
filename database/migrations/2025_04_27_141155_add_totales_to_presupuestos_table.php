<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->decimal('subtotal_mano_obra', 12, 2)->default(0)->after('bps_porcentaje');
            $table->decimal('subtotal_materiales', 12, 2)->default(0)->after('subtotal_mano_obra');
            $table->decimal('subtotal_gastos_fijos', 12, 2)->default(0)->after('subtotal_materiales');
            $table->decimal('utilidad_monto', 12, 2)->default(0)->after('subtotal_gastos_fijos');
            $table->decimal('subtotal_general', 12, 2)->default(0)->after('utilidad_monto');
            $table->decimal('iva_monto', 12, 2)->default(0)->after('subtotal_general');
            $table->decimal('bps_monto', 12, 2)->default(0)->after('iva_monto');
            $table->decimal('total_final', 12, 2)->default(0)->after('bps_monto');
        });
    }

    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal_mano_obra',
                'subtotal_materiales',
                'subtotal_gastos_fijos',
                'utilidad_monto',
                'subtotal_general',
                'iva_monto',
                'bps_monto',
                'total_final',
            ]);
        });
    }
};
