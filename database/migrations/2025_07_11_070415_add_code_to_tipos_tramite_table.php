<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('tipos_tramite', function (Blueprint $table) {
            $table->string('code')->after('nombre'); // varchar(255), puede ajustarse
        });
    }

    /**
     * Reverse the migrations.
     */
   public function down()
    {
        Schema::table('tipos_tramite', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
