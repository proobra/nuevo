
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('obras', function (Blueprint $table) {
          $table->id();
           $table->string('nombre');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->date('fecha_aceptacion')->nullable();
           $table->date('fecha_inicio')->nullable();
            $table->integer('duracion_dias');
            $table->enum('estado', ['aceptada', 'en_ejecucion', 'finalizada'])->default('aceptada');
            $table->timestamps();
       });
    }

    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
