<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $opciones1 = ['Matrimonio','Cumpleaños','QuinceAños','Reunion Familiar','Reunion Escolar','Bautizo','Graduacion'];
        $opciones2 = ['Cancelado','Completado','Falta Pagar'];
        return [
            'reserve_date' => $this->faker->dateTimeThisDecade,
            'type' => $this->faker->randomElement($opciones1),
            'event_day' => $this->faker->dateTimeThisYear(),
            'start' => $this->faker->time(),
            'finish' => $this->faker->time(),
            'guests' => $this->faker->numberBetween(50,250),
            'total_cost' => $this->faker->numberBetween(1000,5000),
            'status'=> $this->faker->randomElement($opciones2),
            'client_id'=> $this->faker->numberBetween(1,10)
        ];
    }
}
