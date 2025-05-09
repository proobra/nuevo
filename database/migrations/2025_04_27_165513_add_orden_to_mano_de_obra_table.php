<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mano_de_obra', function (Blueprint $table) {
            $table->unsignedInteger('orden')->nullable()->after('replanteo_id'); // después de replanteo_id
        });
    }

    public function down(): void
    {
        Schema::table('mano_de_obra', function (Blueprint $table) {
            $table->dropColumn('orden');
        });
    }
};
