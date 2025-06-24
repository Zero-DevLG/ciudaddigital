<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'curp',
    ];
}
