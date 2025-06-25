<?php

namespace App\Services;


use Illuminate\Support\Facades\Storage;
use App\App\Models\DocumentosTramite;
use DragonCode\Contracts\Cache\Store;
use Illuminate\Http\UploadedFile;

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
     * @param DocumentoTramite
     */

    public function storeDocumento(
        UploadedFile $archivo,
        int $tramiteId,
        int $tipoDocumentoId,
        string $nombreDocumento = null,
        string $disk = 'public'
    ) {

        #Ruta base
        $rutaCarpeta = "documentos/{$tramiteId}";

        #Comprobar que la carpeta existe
        if (!Storage::disk($disk)->exists($rutaCarpeta)) {
            Storage::disk($disk)->makeDirectory($rutaCarpeta);
        }

        $nombreArchivo = $nombreDocumento ?? $archivo->getClientOriginalName();
        $rutaFinal = $archivo->storeAs($rutaCarpeta, $nombreArchivo, $disk);

        #Eliminar el archivo



    }
}
