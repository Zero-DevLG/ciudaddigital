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
        Schema::create('documentacion_solicitante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tramite_id')->constrained('tramites_c')->onDelete('cascade');

            $table->foreignId('identificacion_oficial_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');
            $table->foreignId('comprobante_domicilio_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');
            $table->foreignId('escritura_publica_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');
            $table->foreignId('poder_notarial_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');
            $table->foreignId('comprobante_pago_impuestos_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');
            $table->foreignId('documentos_adicionales_id')->nullable()->constrained('documentos_tramites')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentacion_solicitante');
    }
};
