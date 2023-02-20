<?php

namespace Database\Factories;

use App\Models\Estados_Pedidos;
use App\Models\TipoEntrega_Pedidos;
use App\Models\usuarios;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cabecera_Pedidos>
 */
class Cabecera_PedidosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "Tipo_Pago_NotaVenta"=>$this->faker->word(),
            "Total_Pago_NotaVenta"=>$this->faker->numberBetween(0,100),
            "Fecha_NotaVenta"=>$this->faker->date(),
            "Direccion_NotaVenta"=>$this->faker->text(50),
            "usuario_id"=>usuarios::all()->random()->id,
            "estados__pedido_id"=>Estados_Pedidos::all()->random()->id,
            "tipo_entrega__pedido_id"=>TipoEntrega_Pedidos::all()->random()->id,
        ];
    }
}
