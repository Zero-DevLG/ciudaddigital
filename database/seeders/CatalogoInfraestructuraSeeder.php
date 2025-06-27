<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatalogoInfraestructura;

class CatalogoInfraestructuraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infraestructuras = [
            'Agua potable',
            'Drenaje',
            'Electricidad',
            'Alumbrado público',
            'Telefonía',
            'Internet',
            'Gas',
            'Vialidades pavimentadas'
        ];

        foreach ($infraestructuras as $infra) {
            CatalogoInfraestructura::create(['infraestructura' => $infra]);
        }
    }
}
