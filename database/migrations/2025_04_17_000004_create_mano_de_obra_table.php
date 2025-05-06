<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mano_de_obra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained()->onDelete('cascade');
            $table->foreignId('replanteo_id')->nullable()->constrained('replanteos')->onDelete('cascade');
            $table->string('categoria');
            $table->decimal('cantidad', 10, 2)->nullable();
            $table->integer('dias')->nullable();
            $table->string('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mano_de_obra');
    }
};
