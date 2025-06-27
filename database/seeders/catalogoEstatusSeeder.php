<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CatalogoEstatusSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('catalogo_estatus')->insert([
            [
                'id' => 1,
                'estado' => 'inicio',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'estado' => 'verificacion',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'estado' => 'analisis_juridico',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'estado' => 'aprobacion',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'estado' => 'prevencion',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
