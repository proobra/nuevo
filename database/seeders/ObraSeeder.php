<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObraSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('obras')->truncate(); // Limpia la tabla antes de insertar

        DB::table('obras')->insert([
            [
                'nombre' => 'Impermeabilización Azotea Sur',
                'cliente_id' => 1,
                'fecha_aceptacion' => now()->subDays(20),
                'fecha_inicio' => now()->subDays(18),
                'duracion_dias' => 20,
                'estado' => 'en_ejecucion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sellado de juntas edificio Rivera',
                'cliente_id' => 1,
                'fecha_aceptacion' => now()->subDays(5),
                'fecha_inicio' => now()->subDays(2),
                'duracion_dias' => 15,
                'estado' => 'en_ejecucion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Reparación terraza edificio Palermo',
                'cliente_id' => 1,
                'fecha_aceptacion' => now()->subDays(2),
                'fecha_inicio' => null,
                'duracion_dias' => 10,
                'estado' => 'aceptada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
