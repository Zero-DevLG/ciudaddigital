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
        Schema::create('prevenciones_tramite', function (Blueprint $table) {
    $table->id();

    // Trámite al que pertenece la prevención
    $table->unsignedBigInteger('tramite_id');

    // Paso que fue prevenido
    $table->unsignedBigInteger('catalogo_paso_id');

    // Observaciones del verificador
    $table->text('observaciones')->nullable();

    // Usuario verificador que registró la prevención
    $table->unsignedBigInteger('verificador_id')->nullable();

    $table->timestamps();

    // Relaciones
    $table->foreign('tramite_id')->references('id')->on('tramites_c')->onDelete('cascade');
    $table->foreign('catalogo_paso_id')->references('id')->on('catalogo_pasos_tramite')->onDelete('cascade');
    $table->foreign('verificador_id')->references('id')->on('users')->onDelete('set null');

    // Evitar duplicados
    $table->unique(['tramite_id', 'catalogo_paso_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('prevenciones_tramite');
    }
};
