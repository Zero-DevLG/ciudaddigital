<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentacionSolicitante extends Model
{
    use SoftDeletes;

    protected $table = 'documentacion_solicitante';

    protected $fillable = [
        'tramite_id',
        'identificacion_oficial_id',
        'comprobante_domicilio_id',
        'escritura_publica_id',
        'poder_notarial_id',
        'comprobante_pago_impuestos_id',
        'documentos_adicionales_id',
    ];

    public function tramite()
    {
        return $this->belongsTo(TramiteC::class, 'tramite_id');
    }

    public function identificacion()
    {
        return $this->belongsTo(DocumentosTramite::class, 'identificacion_oficial_id');
    }

    public function comprobanteDomicilio()
    {
        return $this->belongsTo(DocumentosTramite::class, 'comprobante_domicilio_id');
    }

    public function escritura()
    {
        return $this->belongsTo(DocumentosTramite::class, 'escritura_publica_id');
    }

    public function poderNotarial()
    {
        return $this->belongsTo(DocumentosTramite::class, 'poder_notarial_id');
    }

    public function comprobanteImpuestos()
    {
        return $this->belongsTo(DocumentosTramite::class, 'comprobante_pago_impuestos_id');
    }

    public function adicionales()
    {
        return $this->belongsTo(DocumentosTramite::class, 'documentos_adicionales_id');
    }
}
