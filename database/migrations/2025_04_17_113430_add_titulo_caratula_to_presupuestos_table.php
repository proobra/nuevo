<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos', 'titulo_caratula')) {
                $table->string('titulo_caratula')->nullable()->after('titulo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn('titulo_caratula');
        });
    }
};