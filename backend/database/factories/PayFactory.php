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
        $op = ['transferencia','efectivo','depósito'];
        $op1 = ['Pagando','Completado','Cancelado'];
    
        return [
            'pay_date' => $this->faker->dateTimeThisDecade,
            'amount' => $this->faker->numberBetween(100,1000),
            'pay_type' => $this->faker->randomElement($op),
            'pay_status' => $this->faker->randomElement($op1),
            'deuda' => $this->faker->numberBetween(100,1000),
            'event_id' => $this->faker->numberBetween(1,10)
        ];
    }
}
