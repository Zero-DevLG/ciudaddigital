<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoTipoPropiedad extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            'Privada',
            'Ejidal',
            'Comunal',
            'Pública',
            'Federal',
        ];

        foreach ($tipos as $tipo) {
            DB::table('catalogo_tipo_propiedad')->insert([
                'tipo_propiedad' => $tipo,
                'created_at' => now(),
            ]);
        }
    }
}
