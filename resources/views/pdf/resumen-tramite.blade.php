<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Solicitud</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 100px 40px 80px 40px;
        }

        h1, h2 {
            color: #9D2449;
            margin-bottom: 10px;
        }

        .title {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 25px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .label {
            font-weight: bold;
            color: #444;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .document-list {
            margin-left: 20px;
        }

        .note-box {
            border: 1px solid #999;
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 11px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            border-bottom: 1px solid #ccc;
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
        }

        .logo {
            height: 60px;
        }

        .header-info {
            text-align: right;
            font-size: 12px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #ccc;
            font-size: 11px;
            background-color: #fff;
            padding: 5px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qr-box {
            text-align: center;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 6px;
            max-width: 200px;
        }

        .qr-text {
            font-size: 11px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Encabezado con logo y datos -->
    <div class="header">
        <div>
            <img src="{{ $logo }}" alt="Logo institucional" class="logo">
        </div>
        <div class="header-info">
            <div><strong>Folio:</strong> {{ $folio }}</div>
            <div><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
        </div>
    </div>

    <!-- Título principal -->
    <div class="title">
        <h1>Comprobante de Solicitud de Trámite</h1>
    </div>

    <!-- Nota de aclaración -->
    <div class="note-box">
        <p>
            Este comprobante contiene la información proporcionada por el solicitante al registrar su trámite.
            La recepción del comprobante no representa la aprobación. El expediente será evaluado por la autoridad correspondiente,
            quien podrá solicitar información adicional.
        </p>
        <p>
            Para dar seguimiento al trámite, conserve este documento junto con el número de folio asignado.
        </p>
    </div>

    <!-- Datos del solicitante -->
    <div class="section">
        <h2>Datos del Solicitante</h2>
        <div class="grid">
            <div><span class="label">Nombre:</span> {{ $persona->nombre }} {{ $persona->apellido_paterno }} {{ $persona->apellido_materno }}</div>
            <div><span class="label">CURP:</span> {{ $persona->curp }}</div>
            <div><span class="label">RFC:</span> {{ $persona->rfc }}</div>
            <div><span class="label">Teléfono:</span> {{ $persona->telefono }}</div>
            <div><span class="label">Correo:</span> {{ $persona->correo_electronico }}</div>
        </div>
    </div>

    <!-- Información del Predio -->
    <div class="section">
        <h2>Información del Predio</h2>
        <div class="grid">
            <div><span class="label">Clave Catastral:</span> {{ $predio->clave_catastral }}</div>
            <div><span class="label">Superficie:</span> {{ $predio->superficie_total }} m²</div>
            <div><span class="label">Ubicación:</span>
                {{ $domicilio_predio->calle }} {{ $domicilio_predio->n_exterior }}
                {{ $domicilio_predio->n_interior ? '-' . $domicilio_predio->n_interior : '' }},
                {{ $domicilio_predio->delegacion_municipio }}, {{ $domicilio_predio->estado }},
                C.P. {{ $domicilio_predio->cp }}
            </div>
            <div><span class="label">Uso Actual:</span> {{ $uso_suelo_actual->tipo_uso }}</div>
            <div><span class="label">Uso Solicitado:</span> {{ $uso_suelo_solicitado->tipo_uso }}</div>
            <div><span class="label">Tipo de Propiedad:</span> {{ $tipo_propiedad->tipo_propiedad }}</div>
        </div>
    </div>

    <!-- Características del Proyecto -->
    <div class="section">
        <h2>Características del Proyecto</h2>
        <div class="grid">
            <div><span class="label">Descripción:</span> {{ $tramite_proyecto->descripcion_general }}</div>
            <div><span class="label">Impacto Estimado:</span> {{ $impacto_estimado->impacto }}</div>
            <div><span class="label">Tipo de Construcción:</span> {{ $tipo_construccion->tipo_construccion }}</div>
            <div><span class="label">Niveles:</span> {{ $tramite_proyecto->niveles }}</div>
        </div>

        @if($car_proyecto->infraestructuras->count())
        <div>
            <span class="label">Infraestructura:</span>
            <ul class="document-list">
                @foreach ($car_proyecto->infraestructuras as $infra)
                    <li>{{ $infra->infraestructura }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div><span class="label">Plano del Terreno:</span> {{ $plano_documento->nombre_documento ?? 'No adjunto' }}</div>
        <div><span class="label">Estudio de Impacto Ambiental:</span> {{ $estudio_impacto_documento->nombre_documento ?? 'No adjunto' }}</div>
    </div>

    <!-- Documentos Adjuntos -->
    <div class="section">
        <h2>📎 Documentos Adjuntos</h2>
        @if(count($documentos_tramite))
            <ul class="document-list">
                @foreach ($documentos_tramite as $doc)
                    <li>{{ $doc->nombre_documento }}</li>
                @endforeach
            </ul>
        @else
            <p>No se han adjuntado documentos adicionales.</p>
        @endif
    </div>

    <!-- Código QR -->
    <div class="section" style="display: flex; justify-content: flex-end;">
        <div class="qr-box">
            <p class="qr-text">Escanea este código QR para consultar el estado de tu trámite.</p>
            <img src="{{ $qrSvg }}" alt="Código QR" style="width: 130px; height: 130px;">
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <span>Ciudad Digital</span>
        <span>Página <script>document.write(window.pageNum || 1);</script></span>
    </div>

</body>
</html>
