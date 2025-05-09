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
       // $table->string('descripcion')->nullable();
       // $table->decimal('cantidad_unidades', 10, 2)->nullable();
      //  $table->decimal('costo_unitario', 10, 2)->nullable();
      //  $table->integer('manos')->default(1);
      //  $table->decimal('rendimiento', 10, 2)->nullable();
     //   $table->decimal('litros_por_lata', 10, 2)->nullable();
    });

    Schema::table('presupuestos', function (Blueprint $table) {
        $table->string('titulo_caratula')->nullable();
        $table->dropColumn('cliente_nombre'); // si ya no lo usás
    });


}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('materiales', function (Blueprint $table) {
        $table->dropColumn([
            'descripcion',
            'cantidad_unidades',
            'costo_unitario',
            'manos',
            'rendimiento',
            'litros_por_lata'
        ]);
    });
}

};
