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
        Schema::create('respuestas_formulario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instancia_tramite_id')->constrained('instancia_tramites')->onDelete('cascade');
            $table->foreignId('campo_pasos_id')->constrained('campo_pasos')->onDelete('cascade');

            $table->enum('tipo', ['texto', 'opcion', 'entero', 'decimal', 'booleano', 'fecha', 'archivo']);

            $table->text('valor_texto')->nullable();
            $table->string('valor_opcion')->nullable();
            $table->integer('valor_entero')->nullable();
            $table->decimal('valor_decimal', 10, 2)->nullable();
            $table->boolean('valor_booleano')->nullable();
            $table->date('valor_fecha')->nullable();
            $table->string('archivo_ruta')->nullable();

            $table->timestamps();

            $table->index(['campo_pasos_id', 'tipo']);
            $table->index(['valor_entero']);
            $table->index(['valor_decimal']);
            $table->index(['valor_booleano']);
            $table->index(['valor_opcion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas_formulario_table');
    }
};
