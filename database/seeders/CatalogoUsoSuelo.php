<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoUsoSuelo extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usos = [
            'Habitacional',
            'Comercial',
            'Industrial',
            'Servicios',
            'Equipamiento urbano',
            'Mixto',
            'Agropecuario',
            'Forestal',
            'Recreativo',
            'Reserva ecológica / Protección',
            'Infraestructura',
            'Minero',
        ];

        foreach ($usos as $uso) {
            DB::table('catalogo_uso_suelo')->insert([
                'tipo_uso'   => $uso,
                'created_at' => now(),
            ]);
        }
    }
}
