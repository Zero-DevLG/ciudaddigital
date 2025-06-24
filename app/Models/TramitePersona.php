<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory, SoftDeletes;

class TramitePersona extends Model
{
    //


    protected $table = 'tramite_personas';

    protected $fillable = [
        'tramite_id',
        'persona_id',
    ];

    public function tramite()
    {
        return $this->belongsTo(TramiteC::class);
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
