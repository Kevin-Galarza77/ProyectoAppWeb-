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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_Producto');
            $table->string('Nombre_Producto');
            $table->integer('Stock_Producto');
            $table->decimal('Precio_Producto');
            $table->string('public_id');
            $table->string('url');
            $table->string('Descripcion_Producto');
            $table->unsignedBigInteger('subCategoria_id');

            $table->foreign('subCategoria_id')->references('id')
                ->on('sub_categorias')
                ->onDelete('cascade')
                ->onUpdate('cascade');


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
        Schema::dropIfExists('productos');
    }
};
