<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatalogoCargo;

class CatalogoCargoSeeder extends Seeder
{
    public function run()
    {
        $cargos = [
            ['nombre_cargo' => 'Solicitante', 'active' => true],
            ['nombre_cargo' => 'Director de Urbanismo', 'active' => true],
            ['nombre_cargo' => 'Jefe de Departamento de Uso de Suelo', 'active' => true],
            ['nombre_cargo' => 'Inspector Municipal', 'active' => true],
            ['nombre_cargo' => 'Coordinador de Evaluación Ambiental', 'active' => true],
            ['nombre_cargo' => 'Secretario de Obras Públicas', 'active' => true],
            ['nombre_cargo' => 'Analista de Trámites', 'active' => true],
            ['nombre_cargo' => 'Verificador de Trámites', 'active' => true],
            ['nombre_cargo' => 'Director General de Planeación Urbana', 'active' => true],
            ['nombre_cargo' => 'Encargado de Archivo y Documentación', 'active' => true],
        ];

        foreach ($cargos as $cargo) {
            CatalogoCargo::updateOrCreate(
                ['nombre_cargo' => $cargo['nombre_cargo']],
                ['active' => $cargo['active']]
            );
        }
    }
}
