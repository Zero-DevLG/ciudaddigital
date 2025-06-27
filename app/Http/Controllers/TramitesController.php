<?php

namespace App\Http\Controllers;

use App\Models\TipoTramite;
use App\Models\TramiteC;
use App\Models\CatalogoPasosTramite;
use Illuminate\Http\Request;

class TramitesController extends Controller
{
    public function iniciar($id)
    {
        // Buscar el trámite por ID
        $tramite_tipo = TipoTramite::findOrFail($id);
        #dd($tramite);
        // Si es tipo 1, mostrar el componente Livewire 'tramite_uso_suelo'
        if ($tramite_tipo->id == 1) {


            //creat tramite

            $tramite = TramiteC::create([
                'folio' => null,
                'tipo_tramite_id' => $tramite_tipo->id,
                'cat_estatus_id' => 1,
                'tramite_inicio' => now(),
                'tramite_termino' => null,
                'created_at' => now()
            ]);


            // Crear puntero de pasos

            $pasos_puntero = CatalogoPasosTramite::where('tipo_tramite_id', $tramite_tipo->id)
                ->orderBy('n_paso')
                ->get();




            // Redirige a la vista del trámite creado, pasando el id
            return redirect()->route('tramites.uso_suelo', ['tramite' => $tramite->id]);
        }
        // ...puedes agregar más condiciones para otros tipos aquí...
    }


    public function mostrarTramite(TramiteC $tramite)
    {
        $tramite_tipo = TipoTramite::findOrFail($tramite->tipo_tramite_id);

        // Trae los pasos para ese tipo de trámite
        $pasos_puntero = CatalogoPasosTramite::where('tipo_tramite_id', $tramite_tipo->id)
            ->orderBy('n_paso')
            ->get();

        // Retorna la vista con los datos del trámite existente
        return view('tramites.tramite_uso_suelo', compact('tramite', 'tramite_tipo', 'pasos_puntero'));
    }
}
