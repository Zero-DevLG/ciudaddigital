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
        //
        Schema::create('documentos_temporales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tramite_id')->constrained('tramites_c')->onDelete('cascade');
            $table->string('nombre_archivo');
            $table->string('url');
            $table->string('tipo_documento');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('documentos_temporales');
    }
};
