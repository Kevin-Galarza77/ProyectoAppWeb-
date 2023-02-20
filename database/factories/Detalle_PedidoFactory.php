<?php

namespace Database\Factories;

use App\Models\Cabecera_Pedidos;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Detalle_Pedido>
 */
class Detalle_PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "Cantidad_Productos"=>$this->faker->numberBetween(0,250),
            "Subtotal_Productos"=>$this->faker->numberBetween(0,250),
            "producto_id"=>Producto::all()->random()->id,
            "cabecera__pedido_id"=>Cabecera_Pedidos::all()->random()->id
        ];
    }
}
