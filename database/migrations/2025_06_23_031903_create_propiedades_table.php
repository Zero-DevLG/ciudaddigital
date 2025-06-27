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
        Schema::create('predios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domicilio_id')->constrained('domicilios')->onDelete('cascade');
            $table->string('clave_catastral');
            $table->decimal('lat', 10, 7);   // Latitud con precisión adecuada
            $table->decimal('long', 10, 7);  // Longitud con precisión adecuada
            $table->decimal('superficie_total', 10, 2);

            $table->foreignId('uso_actual_suelo_id')->constrained('catalogo_uso_suelo')->onDelete('restrict');
            $table->foreignId('tipo_propiedad_id')->constrained('catalogo_tipo_propiedad')->onDelete('restrict');
            $table->foreignId('uso_solicitado_id')->constrained('catalogo_uso_suelo')->onDelete('restrict');

            $table->boolean('acceso_vialidades')->default(false);
            $table->boolean('zona_urbana')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedades');
    }
};
