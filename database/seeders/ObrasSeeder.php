<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ObrasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('obras')->insert([
            'nombre' => 'Impermeabilización de terraza 50m²',
            'fecha_inicio' => Carbon::now()->subDays(10),
            'duracion_dias' => 20,
            'estado' => 'en_ejecucion',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
