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
        $codigo = Str::upper(Str::random(3)) . $this->faker->unique()->numberBetween(1000, 9999);

        return [
            'codigo' => $codigo,
            'nombre' => $nombre,
            'correo' => $this->faker->unique()->safeEmail(),
            'fecha_nacimiento' => $this->faker->dateTimeBetween('-30 years', '-18 years'),
            'sexo' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'carrera' => $this->faker->randomElement([
                'Ingeniería en Sistemas',
                'Administración',
                'Marketing',
                'Diseño Gráfico',
                'Derecho',
            ]),
        ];
    }
}
