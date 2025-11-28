<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumnoControllerTest extends TestCase
{
    use RefreshDatabase;

    private function signIn(): User
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        return $user;
    }

    public function test_se_listan_alumnos(): void
    {
        $this->signIn();
        $alumnos = Alumno::factory()->count(2)->create();

        $response = $this->get(route('alumnos.index'));

        $response->assertOk()
            ->assertViewIs('alumnos.index')
            ->assertViewHas('alumnos', function ($paginator) use ($alumnos) {
                if (! method_exists($paginator, 'getCollection')) {
                    return false;
                }

                $collection = $paginator->getCollection();

                return $collection->count() === $alumnos->count()
                    && $collection->pluck('id')->diff($alumnos->pluck('id'))->isEmpty();
            });

        foreach ($alumnos as $alumno) {
            $response->assertSeeText($alumno->nombre);
        }
    }

    public function test_se_muestra_formulario_de_creacion_de_alumno(): void
    {
        $this->signIn();

        $this->get(route('alumnos.create'))
            ->assertOk()
            ->assertViewIs('alumnos.create');
    }

    public function test_se_muestra_formulario_de_edicion_de_alumno(): void
    {
        $this->signIn();
        $alumno = Alumno::factory()->create();

        $this->get(route('alumnos.edit', $alumno))
            ->assertOk()
            ->assertViewIs('alumnos.edit')
            ->assertViewHas('alumno', fn ($viewAlumno) => $viewAlumno->is($alumno));
    }

    public function test_se_muestra_detalle_de_alumno(): void
    {
        $this->signIn();
        $alumno = Alumno::factory()->create();

        $this->get(route('alumnos.show', $alumno))
            ->assertOk()
            ->assertViewIs('alumnos.show')
            ->assertViewHas('alumno', fn ($viewAlumno) => $viewAlumno->is($alumno))
            ->assertSeeText($alumno->nombre);
    }

    public function test_se_puede_crear_un_alumno(): void
    {
        $this->signIn();

        $data = [
            'codigo' => 123456789, // usar entero
            'nombre' => 'Juan Perez',
            'correo' => 'juan.perez@example.com',
            'fecha_nacimiento' => '2000-01-15',
            'sexo' => 'Masculino',
            'carrera' => 'ICOM', // valor válido del enum
        ];

        $response = $this->post(route('alumnos.store'), $data);

        $response->assertRedirect(route('alumnos.index'))
            ->assertSessionHas('success', 'Alumno creado correctamente.');

        $this->assertDatabaseHas('alumnos', [
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'carrera' => $data['carrera'],
        ]);
    }

    public function test_se_puede_editar_un_alumno(): void
    {
        $this->signIn();

        $alumno = Alumno::factory()->create([
            'codigo' => 987654321,
            'nombre' => 'Maria Lopez',
            'correo' => 'maria.lopez@example.com',
            'fecha_nacimiento' => '1999-03-21',
            'sexo' => 'Femenino',
            'carrera' => 'LIAD',
        ]);

        $updates = [
            'codigo' => 987654321,
            'nombre' => 'Maria Gomez',
            'correo' => 'maria.gomez@example.com',
            'fecha_nacimiento' => '1998-12-10',
            'sexo' => 'Femenino',
            'carrera' => 'ENFE', // valor válido del enum
        ];

        $response = $this->put(route('alumnos.update', $alumno), $updates);

        $response->assertRedirect(route('alumnos.show', $alumno))
            ->assertSessionHas('success', 'Alumno actualizado correctamente.');

        $alumno->refresh();

        $this->assertEquals($updates['codigo'], $alumno->codigo); // no strict para evitar mismatch de tipo
        $this->assertSame($updates['nombre'], $alumno->nombre);
        $this->assertSame($updates['correo'], $alumno->correo);
        $this->assertSame($updates['fecha_nacimiento'], $alumno->fecha_nacimiento->toDateString());
        $this->assertSame($updates['sexo'], $alumno->sexo);
        $this->assertSame($updates['carrera'], $alumno->carrera->value); // carrera casteada a enum

        $this->assertDatabaseHas('alumnos', [
            'id' => $alumno->id,
            'correo' => $updates['correo'],
        ]);
    }

    public function test_se_puede_eliminar_un_alumno(): void
    {
        $this->signIn();

        $alumno = Alumno::factory()->create([
            'codigo' => 111222333,
            'nombre' => 'Carlos Ruiz',
            'correo' => 'carlos.ruiz@example.com',
            'fecha_nacimiento' => '1997-07-07',
            'sexo' => 'Masculino',
            'carrera' => 'LINI',
        ]);

        $response = $this->delete(route('alumnos.destroy', $alumno));

        $response->assertRedirect(route('alumnos.index'))
            ->assertSessionHas('success', 'Alumno eliminado correctamente.');

        $this->assertDatabaseMissing('alumnos', ['id' => $alumno->id]);
    }
}
