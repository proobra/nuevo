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
        Schema::create('replanteos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained('presupuestos')->onDelete('cascade');
            $table->string('descripcion')->nullable();
            $table->decimal('m2', 10, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replanteos');
    }
};
