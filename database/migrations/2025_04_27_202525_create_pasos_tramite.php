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
        Schema::create('pasos_tramite', function (Blueprint $table) {
            $table->id();
            $table->integer('tramite_formato_id');
            $table->string('titulo_paso');
            $table->string('descripcion');
            $table->integer('orden');
            $table->boolean('estatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasos_tramite');
    }
};
