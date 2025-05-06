<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('replanteos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('presupuesto_id');
            $table->string('descripcion_tarea');
            $table->integer('orden')->default(0);
            $table->integer('dias')->nullable();
            $table->decimal('metros2', 8, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('replanteos');
    }
};
