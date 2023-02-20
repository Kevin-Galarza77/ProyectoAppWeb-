<?php

namespace Database\Factories;

use App\Models\rol;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\usuario>
 */
class UsuariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'CI_Usuario'=>$this->faker->text(10),
            'Nombre_Usuario'=>$this->faker->name(),
            'FechaNacimiento_Usuario'=>$this->faker->date(),
            'Cel_Usuario'=>$this->faker->phoneNumber(),
            'Direccion_Usuario'=>$this->faker->text(50),
            'user_id'=>User::all()->random()->id,
            'rol_id'=>rol::all()->random()->id
        ];
    }
}
