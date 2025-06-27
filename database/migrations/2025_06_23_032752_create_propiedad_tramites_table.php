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
        Schema::create('propiedad_tramite', function (Blueprint $table) {
            $table->id();

            $table->foreignId('propiedad_id')->constrained('predios')->onDelete('cascade');
            $table->foreignId('tramite_id')->constrained('tramites_c')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propiedad_tramites');
    }
};
