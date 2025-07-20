<?php

namespace App\Http\Controllers;

use App\Services\PDFService;

class PdfController extends Controller
{
    public function exportar(PDFService $PDFService)
    {
        $data = [
            'nombre' => 'Luis Gabriel',
            'fecha' => now()->format('d/m/Y'),
        ];


    }
}
