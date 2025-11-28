<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Alumno>
 */
class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    public function definition(): array
    {
        $nombre = $this->faker->name();

        return [
            'codigo' => $this->faker->unique()->numberBetween(200000000, 299999999),
            'nombre' => $nombre,
            'correo' => $this->faker->unique()->safeEmail(),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'sexo' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'carrera' => $this->faker->randomElement([
                'ICOM',
                'LIAD',
                'LINI',
                'LDCG',
                'DECH',
                'ENFE',
            ]),
        ];
    }
}
