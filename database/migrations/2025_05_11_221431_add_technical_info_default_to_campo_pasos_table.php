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
        Schema::table('campo_pasos', function (Blueprint $table) {
            // Añadir columna para el nombre técnico/key
            $table->string('nombre_tecnico')->nullable()->after('nombre_campo');

            // Añadir columna para la información adicional/ayuda
            $table->string('info_adicional')->nullable()->after('opciones'); // O donde prefieras ubicarla

            // Añadir columna para el valor predeterminado
            $table->string('valor_predeterminado')->nullable()->after('info_adicional'); // O donde prefieras ubicarla
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campo_pasos', function (Blueprint $table) {
            // Eliminar las columnas si se hace rollback
            $table->dropColumn(['nombre_tecnico', 'info_adicional', 'valor_predeterminado']);
        });
    }
};
