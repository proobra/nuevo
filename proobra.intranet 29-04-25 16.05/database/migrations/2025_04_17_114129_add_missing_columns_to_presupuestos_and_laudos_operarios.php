<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToPresupuestosAndLaudosOperarios extends Migration
{
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos', 'fecha')) {
                $table->dateTime('fecha')->nullable()->after('email');
            }
            if (!Schema::hasColumn('presupuestos', 'fecha_inicio')) {
                $table->dateTime('fecha_inicio')->nullable()->after('fecha');
            }
            if (!Schema::hasColumn('presupuestos', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('titulo');
            }
            if (!Schema::hasColumn('presupuestos', 'titulo_caratula')) {
                $table->string('titulo_caratula')->nullable()->after('titulo');
            }
            if (!Schema::hasColumn('presupuestos', 'bps_mano_obra')) {
                $table->decimal('bps_mano_obra', 10, 2)->nullable()->after('descripcion');
            }
        });

        Schema::table('laudos_operarios', function (Blueprint $table) {
            if (!Schema::hasColumn('laudos_operarios', 'orden')) {
                $table->integer('orden')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn([
                'fecha',
                'fecha_inicio',
                'descripcion',
                'titulo_caratula',
                'bps_mano_obra',
            ]);
        });

        Schema::table('laudos_operarios', function (Blueprint $table) {
            $table->dropColumn('orden');
        });
    }
}
