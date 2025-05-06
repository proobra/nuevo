<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materiales', function (Blueprint $table) {
            if (!Schema::hasColumn('materiales', 'replanteo_id')) {
                $table->unsignedBigInteger('replanteo_id')->nullable()->after('presupuesto_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('materiales', function (Blueprint $table) {
            if (Schema::hasColumn('materiales', 'replanteo_id')) {
                $table->dropColumn('replanteo_id');
            }
        });
    }
};
