<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('replanteos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained()->onDelete('cascade');
            $table->string('descripcion')->nullable();
            $table->integer('orden')->nullable();
            $table->decimal('m2', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('replanteos');
    }
};
