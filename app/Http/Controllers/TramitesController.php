<?php

namespace App\Http\Controllers;

use App\Models\TipoTramite;
use Illuminate\Http\Request;

class TramitesController extends Controller
{
    public function iniciar($id)
    {
        // Buscar el trámite por ID
        $tramite = TipoTramite::findOrFail($id);
        #dd($tramite);
        // Si es tipo 1, mostrar el componente Livewire 'tramite_uso_suelo'
        if ($tramite->id == 1) {

            return view('tramites.tramite_uso_suelo', compact('tramite'));
        }
        // ...puedes agregar más condiciones para otros tipos aquí...
    }
}
