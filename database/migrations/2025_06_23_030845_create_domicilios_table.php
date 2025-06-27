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
        Schema::create('domicilios', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->string('delegacion_municipio');
            $table->string('calle');
            $table->string('n_exterior');
            $table->string('n_interior')->nullable();
            $table->string('cp', 10); // Código postal como string por ceros a la izquierda
            $table->timestamps();
            $table->softDeletes(); // Agrega columna deleted_at para borrado lógico
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicilios');
    }
};
