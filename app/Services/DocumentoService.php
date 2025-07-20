<?php

namespace App\Services;

use App\Models\DocumentosTemporales;
use Illuminate\Support\Facades\Storage;
use App\Models\DocumentosTramite;
use DragonCode\Contracts\Cache\Store;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use App\Models\Tramite;
use App\Models\CatalogoDocumentos;
use App\Models\TramiteResoluciones;





class DocumentoService
{


    //
    /**
     * Handle the uploaded file.
     *
     * @param UploadedFile $archivo
     * @param int $tramiteId
     * @param int $tipoDocumentoId
     * @param string|null $nombreDocumento
     * @param string $disk
     * @param DocumentosTramite
     */

    public function storeDocumento(
        UploadedFile $archivo,
        int $tramiteId,
        int $tipoDocumentoId,
        string $nombreDocumento = null,
        string $disk = 'public'
    ) {

        //dd($archivo, $tramiteId, $tipoDocumentoId, $nombreDocumento, $disk);

        #Ruta base
        $rutaCarpeta = "documentos/{$tramiteId}";

        #Comprobar que la carpeta existe
        if (!Storage::disk($disk)->exists($rutaCarpeta)) {
            Storage::disk($disk)->makeDirectory($rutaCarpeta);
        }

        $nombreArchivo = $nombreDocumento ?? $archivo->getClientOriginalName();


        $rutaFinal = $archivo->storeAs($rutaCarpeta, $nombreArchivo, $disk);

        // #Eliminar el archivo

         $documentoExistente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', $tipoDocumentoId)
            ->first();


        if($tipoDocumentoId != 3){
             if ($documentoExistente) {
            $documentoExistente->delete();
        }

        }


        return $documento  = DocumentosTramite::create([
            'tramite_id'        => $tramiteId,
            'nombre_documento'  => $nombreArchivo,
            'url'               => $rutaFinal,
            'tipo_documento_id' => $tipoDocumentoId,
        ]);


    }


    public function storeDocumentoTemporal(
        UploadedFile $archivo,
        int $tramiteId,
        int $tipoDocumentoId,
        string $nombreDocumento = null,
        string $disk = 'public'
    ) {
        // Ruta base para documentos temporales
        $rutaCarpeta = "documentos/temporales/{$tramiteId}";

        // Comprobar que la carpeta existe
        if (!Storage::disk($disk)->exists($rutaCarpeta)) {
            Storage::disk($disk)->makeDirectory($rutaCarpeta);
        }

        $nombreArchivo = $nombreDocumento ?? $archivo->getClientOriginalName();

        // Guardar el archivo en la carpeta temporal
        $rutaFinal = $archivo->storeAs($rutaCarpeta, $nombreArchivo, $disk);


        $documentoExistente = DocumentosTramite::where('tramite_id', $tramiteId)
            ->where('tipo_documento_id', $tipoDocumentoId)
            ->first();

        if ($documentoExistente) {
            // Borra el archivo físico anterior
            Storage::disk($disk)->delete($documentoExistente->url);
        }



        return $documento = DocumentosTemporales::create([
            'tramite_id'        => $tramiteId,
            'nombre_archivo'  => $nombreArchivo,
            'url'               => $rutaFinal,
            'tipo_documento' => $tipoDocumentoId,
        ]);
    }







}

