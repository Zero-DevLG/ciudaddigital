<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tramite_resoluciones', function (Blueprint $table) {
            // Primero, eliminar la foreign key
            $table->dropForeign(['documento_id']);

            // Luego, hacer la columna nullable
            $table->unsignedBigInteger('documento_id')->nullable()->change();

            // Volver a aplicar la foreign key
            $table->foreign('documento_id')->references('id')->on('documentos_tramites')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tramite_resoluciones', function (Blueprint $table) {
            // Revertir a NOT NULL
            $table->dropForeign(['documento_id']);
            $table->unsignedBigInteger('documento_id')->nullable(false)->change();
            $table->foreign('documento_id')->references('id')->on('documentos_tramites')->onDelete('cascade');
        });
    }
};
