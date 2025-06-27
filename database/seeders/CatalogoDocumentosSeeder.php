<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatalogoDocumentos;

class CatalogoDocumentosSeeder extends Seeder
{
    public function run()
    {
        $documentos = [
            'acuse_solicitante',
            'acuse_solicitante_firmado',
            'documento_prevencion',
            'acuse_verificador',
            'resolucion_tramite',
            'planos',
            'croquis',
            'estudio_impacto_ambiental',
            'ine',
            'pasaporte',
            'comprobante_domicilio',
            'escritura_publica',
            'poder_notarial',
            'comprobante_pago_impuestos',
            'comprobante_pago_predio',
            'documentos_adicionales',
        ];

        foreach ($documentos as $doc) {
            CatalogoDocumentos::updateOrCreate(
                ['nombre_documento' => $doc]
            );
        }
    }
}
