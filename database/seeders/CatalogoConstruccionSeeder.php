<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CatalogoConstruccion;

class CatalogoConstruccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Casas',
            'Oficinas',
            'Industria',
            'Departamentos',
            'Centros comerciales',
            'Equipamiento urbano',
            'Estacionamientos',
            'Escuelas',
            'Hospitales'
        ];

        foreach ($tipos as $tipo) {
            CatalogoConstruccion::create(['tipo_construccion' => $tipo]);
        }
    }
}
