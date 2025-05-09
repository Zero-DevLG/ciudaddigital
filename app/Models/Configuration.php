<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    //
    protected $table = 'configuration'; // importante si usas nombre en español

    protected $fillable = ['uuid_user', 'clave', 'valor'];
}
