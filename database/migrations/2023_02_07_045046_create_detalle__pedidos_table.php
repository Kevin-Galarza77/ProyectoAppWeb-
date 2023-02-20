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
        Schema::create('detalle__pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('Cantidad_Productos');
            $table->decimal('Subtotal_Productos');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('cabecera__pedido_id')->nullable();


            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('cabecera__pedido_id')->references('id')->on('cabecera__pedidos')->onDelete('set null')->onUpdate('cascade');


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
        Schema::dropIfExists('detalle__pedidos');
    }
};
