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

        Schema::create('tramites_c', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('folio')->unique(); // folio único
            $table->unsignedBigInteger('tipo_tramite_id'); // relación a tipos_tramite
            $table->unsignedBigInteger('cat_estatus_id'); // relación a catalogo_estatus
            $table->dateTime('tramite_inicio')->nullable(); // fecha/hora de inicio
            $table->dateTime('tramite_termino')->nullable(); // fecha/hora de término
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at

            // Llaves foráneas
            $table->foreign('tipo_tramite_id')->references('id')->on('tipos_tramite')->onDelete('cascade');
            $table->foreign('cat_estatus_id')->references('id')->on('catalogo_estatus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites_c');
    }
};
