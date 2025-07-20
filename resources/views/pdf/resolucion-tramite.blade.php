@php
    use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resolución del Trámite</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            font-size: 12pt;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .logo {
            width: 100px;
        }
        .title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 13pt;
        }
        .qr {
            text-align: center;
            margin-top: 50px;
        }
        .payment-info {
            border: 1px solid #888;
            padding: 15px;
            background-color: #f9f9f9;
        }

        table {
        border-collapse: collapse;
        width: 100%;
        }
        th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
        }
        th {
        background-color: #f2f2f2;
        }



    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('img/logo_gobierno.png') }}" alt="Logo Gobierno" class="logo">
        <div>
            <strong>Secretaría de Desarrollo Urbano</strong><br>
            Gobierno del Estado de México<br>
            Dirección General de Uso de Suelo
        </div>
    </div>

    <div class="title">Resolución del Trámite de Uso de Suelo</div>

    <div class="section">
        <div class="section-title">Datos Generales</div>
        <p><strong>Folio:</strong> {{ $tramite->folio }}</p>
        <p><strong>Fecha de Emisión:</strong> Fecha</p>
        <p><strong>Tipo de Resolución:</strong> {{ ucfirst($tipo_resolucion) }}</p>
    </div>

    <div class="section">
        <div class="section-title">Motivo de la Resolución</div>
        <p>{{ $motivo_resolucion }}</p>
    </div>

    @if($tipo_resolucion === 'Positiva')
        <div class="section">
            <div class="section-title">Instrucciones para Proceder al Pago</div>
            <div class="payment-info">
                <p><strong>Importe a pagar:</strong> $1,200.00 MXN</p>
                <p><strong>Concepto:</strong> Expedición de Constancia de Uso de Suelo</p>
                <p><strong>Opciones de Pago:</strong></p>
                <ul>
                    <li>En tiendas <strong>OXXO</strong> o <strong>7-Eleven</strong> con el siguiente número de referencia: <strong>7839203948</strong></li>
                    <li>Pago en línea vía <strong>PayPal</strong>: <a href="https://paypal.me/gobmex">paypal.me/gobmex</a></li>
                    <li>Transferencia bancaria: <br>
                        CLABE: 012180001234567891<br>
                        Banco: BBVA Bancomer<br>
                        Beneficiario: Gobierno del Estado de México
                    </li>
                </ul>
                <p>Conserve el comprobante y entréguelo en la siguiente etapa del trámite.</p>
            </div>
        </div>
    @endif

    @if($tipo_resolucion === 'Prevención')

        <div style="page-break-before: always;"></div>
        <div class="section">
            <table class="table-auto w-full border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1">#</th>
                        <th class="border px-2 py-1">Paso del Trámite</th>
                        <th class="border px-2 py-1">Estatus</th>
                        <th class="border px-2 py-1">Observación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasos as $i => $prev)
                        <tr>
                            <td class="border px-2 py-1">{{ $i + 1 }}</td>
                            <td class="border px-2 py-1">
                                {{ str_replace('_', ' ', ucfirst($prev->paso->nombre_paso)) }}
                            </td>
                            <td class="border px-2 py-1">
                                @if ($prev->es_valido)
                                    Válido
                                @else
                                    No válido
                                @endif
                            </td>
                            <td class="border px-2 py-1">{{ $prev->observaciones }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="left: 40px; right: 40px; font-size: 10pt; text-align: center; color: #333;">
                <p><strong>Nota:</strong> El solicitante cuenta con un plazo máximo de <strong>15 días habiles</strong> para cumplir con las observaciones o requerimientos establecidos en esta resolución.</p>
            </div>


        </div>
    @endif




     <div style="margin-top: 80px; text-align: center;">
        <p style="margin-bottom: 60px;">______________________________</p>
        <p style="font-weight: bold;">{{ Str::title($persona_firmante) }}</p>
        <p style="font-size: 10pt;">{{ $cargo_persona_firmante }}</p>
    </div>

        <div style="page-break-before: always;"></div>

        <div class="qr">
            <p>Escanea este código QR para consultar el estado y validez de tu trámite.</p>
            <img src="{{ $qrSvg }}" alt="Código QR" style="width: 130px; height: 130px;">
        </div>

        <div style="margin-top: 40px; font-size: 10pt; text-align: center; color: #aa0000;">
            <p><strong>Nota:</strong> Si el código QR no te redirige al portal oficial del trámite, este documento carece de validez oficial.</p>
        </div>




</body>
</html>
