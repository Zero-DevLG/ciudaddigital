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
        Schema::create('campo_pasos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasos_tramite_id')->constrained('pasos_tramite')->onDelete('cascade');
            $table->string('nombre_campo');
            $table->string('tipo'); // Ej: text, file, select
            $table->boolean('requerido')->default(false);
            $table->json('opciones')->nullable(); // Solo para tipos como select, radio, checkbox
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campo_pasos');
    }
};
