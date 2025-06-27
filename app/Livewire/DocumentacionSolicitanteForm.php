<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\DocumentoService;


class DocumentacionSolicitanteForm extends Component
{

    use WithFileUploads;
    public $tramiteId;
     public $identificacion;
    public $comprobante_domicilio;
    public $escritura;
    public $poder_notarial;
    public $comprobante_impuestos;
    public $documentos_adicionales;


    public function mount($tramiteId)
    {
        $this->tramiteId = $tramiteId;
    }





    public function render()
    {
        return view('livewire.documentacion-solicitante-form');
    }
}
