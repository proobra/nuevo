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
        Schema::table('mano_de_obra', function (Blueprint $table) {
            $table->unsignedBigInteger('presupuesto_id')->nullable()->after('id');
        
            $table->foreign('presupuesto_id')
                ->references('id')
                ->on('presupuestos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mano_de_obra', function (Blueprint $table) {
            //
        });
    }
};
