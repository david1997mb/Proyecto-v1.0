<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1,6),
            'name' => $this->faker->name,
            'lastname' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->e164PhoneNumber,
            'address' => $this->faker->streetAddress()
        ];
    }
}
