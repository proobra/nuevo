<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GastoFijoConfigurable;

class GastoFijoConfigurableSeeder extends Seeder
{
    public function run(): void
    {
        GastoFijoConfigurable::insert([
            ['nombre' => 'IVA', 'valor' => 22, 'tipo' => 'porcentaje', 'editable' => false],
            ['nombre' => 'Inscripción obra', 'valor' => 1500, 'tipo' => 'monto', 'editable' => true],
            ['nombre' => 'IMM', 'valor' => 3.5, 'tipo' => 'porcentaje', 'editable' => true],
            ['nombre' => 'Responsabilidad civil', 'valor' => 5600, 'tipo' => 'monto', 'editable' => true],
        ]);
    }
}
