<?php

namespace App\Http\Controllers;

use App\Services\PdfService;

class PdfController extends Controller
{
    public function exportar(PdfService $pdfService)
    {
        $data = [
            'nombre' => 'Luis Gabriel',
            'fecha' => now()->format('d/m/Y'),
        ];


    }
}
