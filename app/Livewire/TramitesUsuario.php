<?php

namespace App\Livewire;

use App\Models\Tramite;
use App\Models\TramiteUsuario;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TramitesUsuario extends Component
{

    public $usuario;
    public $tramites;

    public function mount($usuario)
    {
        $this->usuario = $usuario;

        // Obtener los trámites del usuario
       $tramites = DB::table('tramite_usuario as tu')
            ->join('tramites_c as t', 'tu.tramite_id', '=', 't.id')
            ->leftJoin('tipos_tramite as tt', 't.tipo_tramite_id', '=', 'tt.id')
            ->leftJoin('catalogo_estatus as ce', 't.cat_estatus_id', '=', 'ce.id')
            ->where('tu.usuario_id', $usuario->id)
            ->where('cat_estatus_id', '=', 1) // Excluir trámites con estatus 'Cancelado'
            ->select(
                't.id',
                't.folio',
                't.created_at',
                'tt.nombre as tipo_tramite_nombre',
                'ce.estado as catalogo_estatus_estado'
            )
            ->get();


        //dd($tramites);


        $this->tramites = $tramites;


    }


    public function render()
    {
        return view('livewire.tramites-usuario');
    }
}
