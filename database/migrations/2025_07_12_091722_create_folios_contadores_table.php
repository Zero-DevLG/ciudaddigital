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
        Schema::create('folios_contadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_tramite_id')->unique();
            $table->unsignedInteger('ultimo_consecutivo')->default(0);
            $table->timestamps();

            // Foreign key (opcional)
            $table->foreign('tipo_tramite_id')->references('id')->on('tipos_tramite')->onDelete('cascade');

             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folios_contadores');
    }
};
