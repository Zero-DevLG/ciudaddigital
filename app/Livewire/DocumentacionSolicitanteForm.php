<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\DocumentoService;
use App\Models\DocumentosTramite;


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
    // Propiedades para IDs de documentos existentes
    public $identificacion_id_existente;
    public $comprobante_domicilio_id_existente;
    public $escritura_id_existente;
    public $poder_notarial_id_existente;
    public $comprobante_impuestos_id_existente;
    public $documentos_adicionales_id_existente;
    protected $listeners = ['guardarDatos'];


    public function guardarDatos(DocumentoService $documentoService)
    {
        // $this->validate([
        //     'identificacion' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        //     'comprobante_domicilio' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        //     'escritura' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        //     'poder_notarial' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        //     'comprobante_impuestos' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        //     'documentos_adicionales' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        // ]);

        $documentacion = [
            'tramite_id' => $this->tramiteId,
            'identificacion_oficial_id' => ($this->identificacion instanceof \Illuminate\Http\UploadedFile)
                ? $documentoService->storeDocumento(
                    $this->identificacion,
                    $this->tramiteId,
                    9,
                    'Identificación oficial del solicitante'
                )->id
                : $this->identificacion_id_existente,
            'comprobante_domicilio_id' => ($this->comprobante_domicilio instanceof \Illuminate\Http\UploadedFile)
                ? $documentoService->storeDocumento(
                    $this->comprobante_domicilio,
                    $this->tramiteId,
                    11,
                    'Comprobante de domicilio del solicitante'
                )->id
                : $this->comprobante_domicilio_id_existente,
            'escritura_publica' => ($this->escritura instanceof \Illuminate\Http\UploadedFile)
                ? $documentoService->storeDocumento(
                    $this->escritura,
                    $this->tramiteId,
                    12,
                    'Escritura pública del inmueble'
                )->id
                : $this->escritura_id_existente,
            'poder_notarial_id' => ($this->poder_notarial instanceof \Illuminate\Http\UploadedFile)
                ? $documentoService->storeDocumento(
                    $this->poder_notarial,
                    $this->tramiteId,
                    13,
                    'Poder notarial del representante legal'
                )->id
                : $this->poder_notarial_id_existente,
            'comprobante_pago_impuestos_id' => ($this->comprobante_impuestos instanceof \Illuminate\Http\UploadedFile)
                ? $documentoService->storeDocumento(
                    $this->comprobante_impuestos,
                    $this->tramiteId,
                    14,
                    'Comprobante de pago de impuestos'
                )->id
                : $this->comprobante_impuestos_id_existente,
            'documentos_adicionales_id' => ($this->documentos_adicionales instanceof \Illuminate\Http\UploadedFile)
                ? $documentoService->storeDocumento(
                    $this->documentos_adicionales,
                    $this->tramiteId,
                    16,
                    'Documentos adicionales'
                )->id
                : $this->documentos_adicionales_id_existente,
        ];

        $this->dispatch('siguientePaso');
    }


    public function mount($tramiteId)
    {
        $this->tramiteId = $tramiteId;
        $this->identificacion_id_existente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', 9)
            ->whereNull('deleted_at')
            ->value('url');
        $this->comprobante_domicilio_id_existente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', 11)
            ->whereNull('deleted_at')
            ->value('url');
        $this->escritura_id_existente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', 12)
            ->whereNull('deleted_at')
            ->value('url');
        $this->poder_notarial_id_existente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', 13)
            ->whereNull('deleted_at')
            ->value('url');
        $this->comprobante_impuestos_id_existente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', 14)
            ->whereNull('deleted_at')
            ->value('url');
        $this->documentos_adicionales_id_existente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', 16)
            ->whereNull('deleted_at')
            ->value('url');
        // Si quieres mostrar la URL o nombre del archivo existente en el formulario, puedes obtenerlo aparte
    }





    public function render()
    {
        return view('livewire.documentacion-solicitante-form');
    }
}
