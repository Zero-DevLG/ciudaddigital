<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resolución del Trámite</title>
    <style>
        @page {
            margin: 120px 40px 80px 40px; /* top right bottom left */
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12pt;
            color: #333;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 60px;
            font-size: 11px;
            border-top: 1px solid #ccc;
            padding: 5px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            width: 180px;
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

{{-- ENCABEZADO --}}
<header>
    <img src="{{ public_path('img/logo_cd_dor.png') }}" class="logo" alt="Logo">
    <div style="text-align: right;">
        <div><strong>Folio:</strong> {{ $tramite->folio }}</div>
    </div>
</header>

{{-- PIE DE PÁGINA --}}
<footer>
    <span>Ciudad Digital</span>
    <span>Página <script type="text/php">
        if (isset($pdf)) {
            echo $pdf->page_number . " de " . $pdf->page_count;
        }
    </script></span>
</footer>

{{-- CONTENIDO PRINCIPAL --}}
<div class="title">Resolución del Trámite de Uso de Suelo</div>

<div class="section">
    <div class="section-title">Datos Generales</div>
    <p><strong>Folio:</strong> {{ $tramite->folio }}</p>
    <p><strong>Fecha de Emisión:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
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
            <ul>
                <li>Pago en OXXO con referencia: <strong>7839203948</strong></li>
                <li>PayPal: <a href="https://paypal.me/gobmex">paypal.me/gobmex</a></li>
                <li>Transferencia CLABE: 012180001234567891 (BBVA Bancomer)</li>
            </ul>
        </div>
    </div>
@endif

@if($tipo_resolucion === 'Prevención')
    <div style="page-break-before: always;"></div>
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Paso del Trámite</th>
                    <th>Estatus</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasos as $i => $prev)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($prev->paso->nombre_paso)) }}</td>
                        <td>{{ $prev->es_valido ? 'Válido' : 'No válido' }}</td>
                        <td>{{ $prev->observaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; font-size: 10pt; text-align: center;">
            <p><strong>Nota:</strong> El solicitante cuenta con 15 días hábiles para atender las observaciones.</p>
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
    <p><strong>Nota:</strong> Si el código QR no te redirige al portal oficial, este documento no es válido.</p>
</div>

</body>
</html>
