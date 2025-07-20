<?php


namespace App\Services;

use App\Models\CatalogoDocumentos;
use App\Models\DocumentosTramite;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Services\DocumentoService;
use App\Models\TramiteResoluciones;


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

    public function generarPdfVistaPreviaResolucion(array $data)
    {
        $pdf = Pdf::loadView('pdf.resolucion-tramite', $data);
        $tramite = $data['tramite'];
        // Generar un nombre de archivo único

        // Guardar el PDF en el disco temporal
        $tempPath = storage_path('app/temp');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0777, true);
        }

        $tipo_documento = CatalogoDocumentos::where('id', 5)->first();

        $filename = strtoupper($tipo_documento->nombre_documento . '-'   . $tramite->folio . '.pdf');


        $documentoAnterior = DocumentosTramite::where('tramite_id', $tramite->id)
            ->where('tipo_documento_id', 5) // ID del tipo de documento para resolución
            ->first();

        if ($documentoAnterior) {

            Storage::disk('public')->delete($documentoAnterior->url);

            // Si ya existe un documento de resolución, eliminarlo
            $documentoAnterior->delete();
        }


        $tempFilePath = $tempPath . '/' . $filename;

        file_put_contents($tempFilePath, $pdf->output());

          $uploadedFile = new UploadedFile(
            $tempFilePath,
            $filename,
            'application/pdf',
            null,
            true
        );

        $documentoTemporal = $this->documentoService->storeDocumentoTemporal(
            $uploadedFile,
            $tramite->id, // ID del trámite
            5, // ID del tipo de documento
            $filename,
            'public' // Disco donde se guardará el archivo
        );

         // Eliminar el archivo temporal

        unlink($tempFilePath);


        if($data['tipo_resolucion_id'] == 4) {
            $resolucion_temporal = TramiteResoluciones::create([
                'tramite_id' => $tramite->id,
                'tipo_resolucion_id' => $data['tipo_resolucion_id']
            ]);
        }else{
             $resolucion_temporal = TramiteResoluciones::updateOrCreate(
                [
                    'tramite_id' => $tramite->id,
                    'tipo_resolucion_id' => $data['tipo_resolucion_id'],
                ],
                [
                ]
            );

        }



         // Regresar una URL pública para poder incrustar el PDF
        return asset('storage/' . $documentoTemporal->url);


    }

    //Servicio para obten



    public function firmarResolucion( string $pdfPath, string $keyPath,string $cerPath, string $password):string
    {
         $client = new \GuzzleHttp\Client();
         $response = $client->post('http://127.0.0.1:5001/firmar', [
            'multipart' => [
                [
                    'name' => 'pdf',
                    'contents' => fopen($pdfPath, 'r'),
                    'filename' => basename($pdfPath)
                ],
                [
                    'name' => 'key',
                    'contents' => fopen($keyPath, 'r'),
                    'filename' => 'firmado.key'
                ],
                [
                    'name' => 'cer',
                    'contents' => fopen($cerPath, 'r'),
                    'filename' => 'firma.cer'
                ],
                [
                    'name' => 'password',
                    'contents' => $password
                ]
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error al firmar el PDF: ' . $response->getReasonPhrase());
        }

         return $response->getBody()->getContents();



    }



}
