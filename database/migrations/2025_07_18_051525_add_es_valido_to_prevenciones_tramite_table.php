<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prevenciones_tramite', function (Blueprint $table) {
            $table->boolean('es_valido')->default(false)->after('observaciones');
        });
    }

    public function down(): void
    {
        Schema::table('prevenciones_tramite', function (Blueprint $table) {
            $table->dropColumn('es_valido');
        });
    }
};
