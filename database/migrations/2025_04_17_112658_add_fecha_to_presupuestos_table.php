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
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dateTime('fecha')->nullable()->after('email'); // o el campo que tengas ahí antes
        });
    }
    
    public function down()
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }
};
