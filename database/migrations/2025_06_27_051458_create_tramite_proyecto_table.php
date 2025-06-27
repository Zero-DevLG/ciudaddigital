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
         Schema::create('tramite_proyecto', function (Blueprint $table) {
        $table->id();

        $table->foreignId('tramite_id')->constrained('tramites_c')->onDelete('cascade');

        $table->text('descripcion_general')->nullable();
        $table->foreignId('impacto_estimado_id')->nullable()->constrained('catalogo_impactos')->onDelete('set null');
        $table->foreignId('tipo_construccion_id')->nullable()->constrained('catalogo_construccions')->onDelete('set null');
        $table->integer('niveles')->nullable();

        // Relaciones con documentos
        $table->foreignId('plano_documento_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');
        $table->foreignId('estudio_impacto_documento_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');

        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite_proyecto');
    }
};
