<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatalogoResolucion;

class CatalogoResolucionSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Positiva', 'Negativa', 'Desechamiento', 'Prevención'];

        foreach ($tipos as $tipo) {
            CatalogoResolucion::firstOrCreate(['nombre' => $tipo]);
        }
    }
}
