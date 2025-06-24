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
        Schema::create('catalogo_pasos_tramite', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_tramite_id');
            $table->integer('n_paso'); // Número del paso
            $table->string('nombre_paso');
            $table->boolean('estatus')->default(true); // Puede ser texto o enum si tienes un catálogo
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipo_tramite_id')
                ->references('id')
                ->on('tipos_tramite')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_pasos_tramite');
    }
};
