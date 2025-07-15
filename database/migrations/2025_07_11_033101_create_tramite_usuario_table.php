<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTramiteUsuarioTable extends Migration
{
    public function up()
    {
        Schema::create('tramite_usuario', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tramite_id')
                ->constrained('tramites_c')
                ->onDelete('cascade');

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('role'); // Ej. 'solicitante', 'verificador', etc.

            $table->boolean('view')->default(false); // Si ya fue visto

            $table->timestamps();
            $table->softDeletes(); // Campo deleted_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tramite_usuario');
    }
}
