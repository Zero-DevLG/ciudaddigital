<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasosTramiteSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('catalogo_pasos_tramite')->insert([
            [
                'tipo_tramite_id' => 1,
                'n_paso' => 1,
                'nombre_paso' => 'datos_personales_solicitante',
                'estatus' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipo_tramite_id' => 1,
                'n_paso' => 2,
                'nombre_paso' => 'datos_propiedad',
                'estatus' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipo_tramite_id' => 1,
                'n_paso' => 3,
                'nombre_paso' => 'caracteristicas_proyecto',
                'estatus' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipo_tramite_id' => 1,
                'n_paso' => 4,
                'nombre_paso' => 'documentacion_requerida',
                'estatus' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
