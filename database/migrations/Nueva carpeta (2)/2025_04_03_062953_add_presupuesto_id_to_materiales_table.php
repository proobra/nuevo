<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('materiales', function (Blueprint $table) {
            $table->unsignedBigInteger('presupuesto_id')->after('id');

    
            // Si querés forzar integridad referencial:
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('materiales', function (Blueprint $table) {
            $table->dropForeign(['presupuesto_id']);
            $table->dropColumn('presupuesto_id');
        });
    }
    
};
