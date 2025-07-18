<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tramite_resoluciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tramite_id');
            $table->unsignedBigInteger('documento_id');
            $table->unsignedBigInteger('tipo_resolucion_id');

            $table->timestamps();
            $table->softDeletes();

            // Relaciones
            $table->foreign('tramite_id')->references('id')->on('tramites_c')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos_tramites')->onDelete('cascade');
            $table->foreign('tipo_resolucion_id')->references('id')->on('catalogo_resoluciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite_resoluciones');
    }
};
