<?php

namespace Database\Factories;

use App\Models\SubCategoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "codigo_Producto"=>$this->faker->word(),
            "Nombre_Producto"=>$this->faker->word(),
            "Stock_Producto"=>$this->faker->numberBetween(0,100),
            "Precio_Producto"=>$this->faker->numberBetween(0,200),
            "public_id"=>$this->faker->word(),
            "url"=>$this->faker->imageUrl(),
            "Descripcion_Producto"=>"1x12 unidades",
            "subCategoria_id"=>SubCategoria::all()->random()->id
        ];
    }
}
