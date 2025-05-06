<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaudosOperariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('laudos_operarios')->insert([
            [
                'categoria' => 'Peón común cat III',
                'sector' => 'Construcción',
                'laudo_base' => 1656.22,
                'desgaste_ropa' => 97.63,
                'transporte' => 85.42,
                's_balancin' => 58.59,
                'herramientas' => 0.00,
                'alimentos' => 173.82,
                'presentismo_semanal' => 142.57,
                'presentismo_mensual' => 68.41,
                'total_jornal' => 2282.66
            ],
            [
                'categoria' => 'Peón práctico cat IV',
                'sector' => 'Construcción',
                'laudo_base' => 1804.44,
                'desgaste_ropa' => 97.63,
                'transporte' => 85.42,
                's_balancin' => 58.59,
                'herramientas' => 0.00,
                'alimentos' => 173.82,
                'presentismo_semanal' => 142.57,
                'presentismo_mensual' => 68.41,
                'total_jornal' => 2430.88
            ],
            [
                'categoria' => '½ Oficial cat V',
                'sector' => 'Construcción',
                'laudo_base' => 1953.01,
                'desgaste_ropa' => 97.63,
                'transporte' => 85.42,
                's_balancin' => 195.30,
                'herramientas' => 39.04,
                'alimentos' => 195.30,
                'presentismo_semanal' => 154.31,
                'presentismo_mensual' => 74.04,
                'total_jornal' => 2794.05
            ],
            [
                'categoria' => 'Oficial cat VIII',
                'sector' => 'Construcción',
                'laudo_base' => 2612.37,
                'desgaste_ropa' => 97.63,
                'transporte' => 85.42,
                's_balancin' => 195.30,
                'herramientas' => 39.04,
                'alimentos' => 195.30,
                'presentismo_semanal' => 206.41,
                'presentismo_mensual' => 99.04,
                'total_jornal' => 3530.51
            ],
            [
                'categoria' => 'Peón común IyC',
                'sector' => 'Industria y Comercio',
                'laudo_base' => 2018.38,
                'desgaste_ropa' => 0,
                'transporte' => 0,
                's_balancin' => 0,
                'herramientas' => 0,
                'alimentos' => 0,
                'presentismo_semanal' => 0,
                'presentismo_mensual' => 0,
                'total_jornal' => 2018.38
            ],
            [
                'categoria' => 'Peón IyC',
                'sector' => 'Industria y Comercio',
                'laudo_base' => 2197.70,
                'desgaste_ropa' => 0,
                'transporte' => 0,
                's_balancin' => 0,
                'herramientas' => 0,
                'alimentos' => 0,
                'presentismo_semanal' => 0,
                'presentismo_mensual' => 0,
                'total_jornal' => 2197.70
            ],
            [
                'categoria' => 'Medio Oficial IyC',
                'sector' => 'Industria y Comercio',
                'laudo_base' => 2378.83,
                'desgaste_ropa' => 0,
                'transporte' => 0,
                's_balancin' => 0,
                'herramientas' => 0,
                'alimentos' => 0,
                'presentismo_semanal' => 0,
                'presentismo_mensual' => 0,
                'total_jornal' => 2378.83
            ],
            [
                'categoria' => 'Oficial IyC',
                'sector' => 'Industria y Comercio',
                'laudo_base' => 3181.82,
                'desgaste_ropa' => 0,
                'transporte' => 0,
                's_balancin' => 0,
                'herramientas' => 0,
                'alimentos' => 0,
                'presentismo_semanal' => 0,
                'presentismo_mensual' => 0,
                'total_jornal' => 3181.82
            ],
        ]);
    }
}
