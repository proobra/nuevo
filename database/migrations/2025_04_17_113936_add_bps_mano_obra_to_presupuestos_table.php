<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos', 'bps_mano_obra')) {
                $table->decimal('bps_mano_obra', 5, 2)->default(0)->after('descripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn('bps_mano_obra');
        });
    }
};
