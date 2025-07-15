<?php

namespace App\Livewire\Verificador;

use App\Models\TramiteC;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TramitesAsignados extends Component
{


    public $tramites;


    public function mount()
    {
        $tramites = DB::table('tramite_usuario as tu')
            ->join('tramites_c as t', 'tu.tramite_id', '=', 't.id')
            ->leftJoin('tipos_tramite as tt', 't.tipo_tramite_id', '=', 'tt.id')
            ->leftJoin('catalogo_estatus as ce', 't.cat_estatus_id', '=', 'ce.id')
            ->where('cat_estatus_id', '=', 2) // Excluir trámites con estatus 'Cancelado'
            ->select(
                't.id',
                't.folio',
                't.created_at',
                'tt.nombre as tipo_tramite_nombre',
                'ce.estado as catalogo_estatus_estado'
            )
            ->get();


        $this->tramites = $tramites;
    }


    public function render()
    {
        return view('livewire.verificador.tramites-asignados');
    }
}
