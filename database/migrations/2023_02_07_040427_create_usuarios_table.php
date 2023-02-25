<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {

            $table->id();
            $table->string('CI_Usuario');
            $table->string('Nombre_Usuario');
            $table->string('FechaNacimiento_Usuario');
            $table->string('Cel_Usuario')->unique();
            $table->text('Direccion_Usuario');

            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('rol_id')->nullable();

            $table->foreign('user_id')->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('rol_id')->references('id')
                  ->on('rols')
                  ->onDelete('set null')
                  ->onUpdate('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};


