<?php
/*
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            //
        });
    }

   
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            //
        });
    }

    */
    
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->date('fecha')->nullable();
            $table->string('titulo')->nullable();
            $table->string('empresa')->nullable();
            $table->string('cliente')->nullable();
            $table->string('contacto')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->decimal('superficie', 8, 2)->nullable();
            $table->decimal('bps_mano_obra', 5, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropColumn([
                'fecha',
                'titulo',
                'empresa',
                'cliente',
                'contacto',
                'direccion',
                'telefono',
                'email',
                'superficie',
                'bps_mano_obra'
            ]);
        });
    }
};

