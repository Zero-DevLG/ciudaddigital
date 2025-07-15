<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->string('telefono', 15)->nullable()->after('curp');
            $table->string('correo_electronico')->nullable()->after('telefono');
        });
    }

    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'correo_electronico']);
        });
    }
};
