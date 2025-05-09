<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\User;


class CurpController extends Controller
{

    public function validar(Request $request)
    {
        $curp = $request->input('curp');

        if (!$curp) {
            return response()->json(['error' => 'Curp requerida', 400]);
        }




        if (User::where('curp', $curp)->exists()) {
            return response()->json(['message' => 'Ya existe un usuario con esta CURP.'], 422);
        }


        $token = env('VERIFICAMEX_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post('https://api.verificamex.com/v1/scraping/renapo', [
            'curp' => $curp
        ]);
        if ($response->successful()) {
            $data = $response->json();

            $registro = $data['data']['citizen']['registros'][0] ?? null;

            if ($registro) {
                return response()->json([
                    'curp' => $registro['curp'],
                    'nombres' => $registro['nombres'],
                    'primer_apellido' => $registro['primerApellido'],
                    'segundo_apellido' => $registro['segundoApellido'],
                    'fecha_nacimiento' => $registro['fechaNacimiento'],
                    'sexo' => $registro['sexo'],
                    'entidad' => $registro['entidad'],
                ]);
            }

            return response()->json(['error' => 'No se encontraron registros para esa CURP'], 404);
        }

        return response()->json(['error' => 'Error al consultar la API'], $response->status());
    }
}
