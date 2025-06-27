<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('catalogo_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_documento')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalogo_documentos');
    }
}
