<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompensacionesToLaudosOperariosTable extends Migration
{
    public function up()
    {
        Schema::table('laudos_operarios', function (Blueprint $table) {
            $table->string('sector')->default('Construcción')->after('categoria');
            $table->decimal('laudo_base', 10, 2)->default(0)->after('sector');
            $table->decimal('desgaste_ropa', 10, 2)->default(0)->after('laudo_base');
            $table->decimal('transporte', 10, 2)->default(0)->after('desgaste_ropa');
            $table->decimal('s_balancin', 10, 2)->default(0)->after('transporte');
            $table->decimal('herramientas', 10, 2)->default(0)->after('s_balancin');
            $table->decimal('alimentos', 10, 2)->default(0)->after('herramientas');
            $table->decimal('presentismo_semanal', 10, 2)->default(0)->after('alimentos');
            $table->decimal('presentismo_mensual', 10, 2)->default(0)->after('presentismo_semanal');
        });
    }

    public function down()
    {
        Schema::table('laudos_operarios', function (Blueprint $table) {
            $table->dropColumn([
                'sector',
                'laudo_base',
                'desgaste_ropa',
                'transporte',
                's_balancin',
                'herramientas',
                'alimentos',
                'presentismo_semanal',
                'presentismo_mensual',
            ]);
        });
    }
}
