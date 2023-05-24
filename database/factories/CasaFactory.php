<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Casa>
 */
class CasaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'urlFoto'       => $this->faker->randomElement(['casas/disponibles/apple.png']),
            'direccion'     => $this->faker->randomElement(['carrera1', 'carrera2']),
            'costoAlquiler' => $this->faker->randomElement([1000, 15000]),
            'ancho'         => $this->faker->randomElement([12.9, 80.7]),
            'largo'         => $this->faker->randomElement([12.8, 34.9]),
            'numeroPisos'   => $this->faker->randomElement([3, 2]),
            'descripcion'   => $this->faker->randomElement(['casa que es la mas pro', 'Casa cualquiera']),
            'capacidad'     => $this->faker->randomElement([2, 4]),
            'idCategoria'   => $this->faker->randomElement([1, 2]),
            'idEstado'      => $this->faker->randomElement([2, 2]),
        ];
    }
}
