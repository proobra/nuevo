<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gastos_fijos_configurables', function (Blueprint $table) {
       //     $table->boolean('editable')->default(true); // sin ->after()
        });
    }

    public function down(): void
    {
        Schema::table('gastos_fijos_configurables', function (Blueprint $table) {
            $table->dropColumn('editable');
        });
    }
};