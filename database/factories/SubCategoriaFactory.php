<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubCategoria>
 */
class SubCategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre'   => $this->faker->sentence(),
            'public_id'=> $this->faker->paragraph(),
            'url'      => $this->faker->imageUrl(),
            'categoria_id' => Categoria::all()->random()->id
        ];
    }
}
