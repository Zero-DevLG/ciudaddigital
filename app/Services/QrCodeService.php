<?php
namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Route;

class QrCodeService
{
    public function generarQrDesdeRuta(string $ruta, array $parametros = [], int $size = 150): string
    {
        if (Route::has($ruta)) {
            $url = route($ruta, $parametros);
        } else {
            $url = url($ruta);
        }

         $pngData = QrCode::format('png')->size($size)->generate($url);

        return 'data:image/png;base64,' . base64_encode($pngData);


    }

    public function generarQrBase64DesdeRuta(string $ruta, array $parametros = [], int $size = 150): string
    {
        if (Route::has($ruta)) {
                $url = route($ruta, $parametros);
            } else {
                $url = url($ruta);
            }

            $pngData = QrCode::format('png')->size($size)->generate($url);

            return 'data:image/png;base64,' . base64_encode($pngData);
        }
}
