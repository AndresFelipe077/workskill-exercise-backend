<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),
            'urlFoto' => $this->faker->randomElement(['profile/user/a.png']), 
            'identificacion' => $this->faker->randomElement([123123123]),
            'fechaNacimiento' => $this->faker->randomElement(['1990-12-12']),
            'usuario'       => $this->faker->randomElement(['pepe']),
            'rol'           => $this->faker->randomElement(['admin']),
            'password' => bcrypt(123), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
