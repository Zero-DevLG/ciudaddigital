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
        Schema::table('tramite_resoluciones', function (Blueprint $table) {
            $table->date('fecha_emision')->nullable()->after('tipo_resolucion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('tramite_resoluciones', function (Blueprint $table) {
            $table->dropColumn('fecha_emision');
        });
    }
};
