<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeccionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'seccion' => strtoupper($this->faker->bothify('?##')), // ej. "D03"
            'aula'    => strtoupper($this->faker->bothify('A###')),
        ];
    }
}
