<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presupuesto;
use App\Models\Replanteo;

class PresupuestoReplanteoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear un presupuesto de prueba
        $presupuesto = Presupuesto::create([
            'cliente_nombre' => 'Cliente de Prueba',
            'descripcion' => 'Impermeabilización de fachada',
            'fecha_inicio' => now()->toDateString(),
            'duracion_dias' => 20,
        ]);

        // Tareas de replanteo
        $tareas = [
            ['descripcion_tarea' => 'Implantación', 'orden' => 1, 'dias' => 2, 'metros2' => 14.0, 'observaciones' => ''],
            ['descripcion_tarea' => 'Hidrolavado', 'orden' => 2, 'dias' => 1, 'metros2' => 10.5, 'observaciones' => ''],
            ['descripcion_tarea' => 'Arreglos de albañilería', 'orden' => 3, 'dias' => 2, 'metros2' => 8.0, 'observaciones' => ''],
            ['descripcion_tarea' => '1 mano de sellador fijador', 'orden' => 4, 'dias' => 1, 'metros2' => 9.0, 'observaciones' => ''],
            ['descripcion_tarea' => '3 manos de pintura elastomérica', 'orden' => 5, 'dias' => 3, 'metros2' => 12.5, 'observaciones' => ''],
        ];

        foreach ($tareas as $tarea) {
            $tarea['presupuesto_id'] = $presupuesto->id;
            Replanteo::create($tarea);
        }
    }
}
