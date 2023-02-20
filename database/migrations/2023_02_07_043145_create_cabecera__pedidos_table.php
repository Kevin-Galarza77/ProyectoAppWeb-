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
        Schema::create('cabecera__pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('Tipo_Pago_NotaVenta');
            $table->decimal('Total_Pago_NotaVenta');
            $table->date('Fecha_NotaVenta');
            $table->text('Direccion_NotaVenta');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('estados__pedido_id')->nullable();
            $table->unsignedBigInteger('tipo_entrega__pedido_id')->nullable();


            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('estados__pedido_id')->references('id')->on('estados__pedidos')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('tipo_entrega__pedido_id')->references('id')->on('tipo_entrega__pedidos')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     *   SQLSTATE[HY000]: General error: 1005 Can't create table `proyectoappweb`.`cabecera__pedidos` (errno: 150 "Foreign key constraint is incorrectly formed") (SQL: alter table `cabecera__pedidos` add constraint `cabecera__pedidos_usuario_id_foreign` foreign key (`usuario_id`) references `usuarios` (`id`) on delete set null on update cascade)
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cabecera__pedidos');
    }
};
