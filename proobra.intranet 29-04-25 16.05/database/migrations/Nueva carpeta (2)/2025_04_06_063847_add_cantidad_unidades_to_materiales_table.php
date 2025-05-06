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
    Schema::table('materiales', function (Blueprint $table) {
        $table->integer('cantidad_unidades')->nullable();
    });
}

public function down(): void
{
    Schema::table('materiales', function (Blueprint $table) {
        $table->dropColumn('cantidad_unidades');
    });
}
};
