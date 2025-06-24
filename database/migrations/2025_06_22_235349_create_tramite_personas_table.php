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
        Schema::create('tramite_personas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tramite_id')
                ->constrained('tramites_c')
                ->onDelete('cascade');

            $table->foreignId('persona_id')
                ->constrained('personas')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite_personas');
    }
};
