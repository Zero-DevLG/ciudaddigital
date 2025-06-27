<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos_tramites', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tramite_id')->constrained('tramites_c')->onDelete('cascade');

            $table->string('nombre_documento');

            $table->string('url'); // ruta o url del archivo almacenado

            $table->foreignId('tipo_documento_id')->constrained('catalogo_documentos')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_tramites');
    }
};
