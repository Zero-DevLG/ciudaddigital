<?php


namespace App\Services;

use App\Models\CatalogoDocumentos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

use App\Services\DocumentoService;

class PdfService
{
    /**
     * Genera y descarga el resumen del trámite como PDF.
     *
     * @param array $data Datos para la vista PDF
     * @param string $nombreArchivo Nombre deseado para el PDF
     * @return \Symfony\Component\HttpFoundation\Response
     */

    protected $documentoService;

    public function __construct(DocumentoService $documentoService)
    {
        $this->documentoService = $documentoService;
    }


    public function descargarResumenTramite(array $data, string $nombreArchivo)
    {
        $pdf = Pdf::loadView('pdf.resumen-tramite', $data);

        $tipo_documento = CatalogoDocumentos::where('id', $data['tipo_documento'])->first();

        //dd($data);

        $tempPath = storage_path('app/temp');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0777, true);
        }

        $filename = strtoupper($tipo_documento->nombre_documento . '-' .  $data['tramite']->tipo_tramite_code . '-'   . $data['folio']) . '.pdf';

        $tempFilePath = $tempPath . '/' . $filename;

        file_put_contents($tempFilePath, $pdf->output());

        $uploadedFile = new UploadedFile(
            $tempFilePath,
            $filename,
            'application/pdf',
            null,
            true
        );


             $documento = $this->documentoService->storeDocumento(
            $uploadedFile,
            $data['tramite_proyecto']['tramite_id'], // ID del trámite
            1, // ID del tipo de documento
            $filename,
            'public' // Disco donde se guardará el archivo
        );

        unlink($tempFilePath);

        return $documento;


    }
}
