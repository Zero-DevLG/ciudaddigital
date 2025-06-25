<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatalogoImpacto;

class CatalogoImpactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $impactos = [
            'Vehicular',
            'Ambiental',
            'Social',
            'Económico',
            'Urbano',
            'Cultural',
            'Paisajístico'
        ];

        foreach ($impactos as $impacto) {
            CatalogoImpacto::updateOrCreate(['impacto' => $impacto]);
        }
    }
}
