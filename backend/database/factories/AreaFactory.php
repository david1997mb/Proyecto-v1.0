<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista de nombres de áreas
        $areaNames = [
            'Patio Trasero',
            'Baños',
            'Deposito Subterraneo',
            'Comedores Mezanine',
            'Comedores Primer Piso',
            'Cuarto Tocador',
            'Pista Central',
            'Cantina',
            'Kiosko',
            'Sala Estar',
            'Escenario Principal',
            'Mesa Central',
            'Mesa Dulce',
        ];

        // Selecciona un nombre aleatorio de la lista
        $name = $this->faker->unique()->randomElement($areaNames);

        return [
            'name' => $name,
        ];
    }
}

