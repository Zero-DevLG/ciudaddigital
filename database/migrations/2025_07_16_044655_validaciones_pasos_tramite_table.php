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
         Schema::create('validaciones_pasos_tramite', function (Blueprint $table) {
            $table->id();

            // Referencia al trámite
            $table->unsignedBigInteger('tramite_id');

            // Referencia al paso (de la tabla catalogo_pasos_tramite)
            $table->unsignedBigInteger('catalogo_paso_id');

            // Estado de validación: válido o inválido
            $table->boolean('es_valido')->default(true);

            // Observaciones si es inválido
            $table->text('observaciones')->nullable();

            // Usuario verificador que validó
            $table->unsignedBigInteger('verificador_id')->nullable();

            $table->timestamps();

            // Relaciones
            $table->foreign('tramite_id')->references('id')->on('tramites_c')->onDelete('cascade');
            $table->foreign('catalogo_paso_id')->references('id')->on('catalogo_pasos_tramite')->onDelete('cascade');
            $table->foreign('verificador_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validaciones_pasos_tramite');
    }
};
