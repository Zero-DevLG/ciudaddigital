<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoCargoTable extends Migration
{
    public function up()
    {
        Schema::create('catalogo_cargo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cargo');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalogo_cargo');
    }
}
