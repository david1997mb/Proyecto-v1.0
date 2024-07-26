<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pay>
 */
class PayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => $this->faker->numberBetween(1, 10),
            'amount'=> $this->faker->randomFloat(2, 100, 1000),
            'pay_date' => $this->faker->dateTimeThisYear(),
            'method' => $this->faker->randomElement(['Efectivo','Transferencia','Deposito','Tarjeta']),
        ];
    }
}
