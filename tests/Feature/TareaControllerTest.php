<?php

namespace Tests\Feature;

use App\Mail\TareaCreada;
use App\Models\Alumno;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TareaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_puede_ver_formulario_de_creacion(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tareas.create'));

        $response->assertOk()
            ->assertSee('Crear Tarea');
    }

    public function test_crear_tarea_guarda_registro_y_redirige(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $payload = [
            'nombre' => 'Tarea demostracion',
            'descripcion' => 'Contenido detallado para la prueba.',
            'fecha_entrega' => now()->addDays(5)->toDateString(),
        ];

        $response = $this->actingAs($user)->post(route('tareas.store'), $payload);

        $tarea = Tarea::first();

        $response->assertRedirect(route('tareas.show', $tarea))
            ->assertSessionHas('success', 'Tarea creada correctamente.');

        $this->assertNotNull($tarea);
        $this->assertDatabaseHas('tareas', [
            'id' => $tarea->id,
            'nombre' => 'Tarea demostracion',
            'user_id' => $user->id,
        ]);
    }

    public function test_crear_tarea_con_datos_invalidos_regresa_errores(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $payload = [
            'nombre' => '',
            'descripcion' => 'Solo descripcion sin nombre.',
            'fecha_entrega' => now()->addDays(2)->toDateString(),
        ];

        $response = $this->actingAs($user)->from(route('tareas.create'))
            ->post(route('tareas.store'), $payload);

        $response->assertRedirect(route('tareas.create'));
        $response->assertSessionHasErrors(['nombre']);
        $this->assertSame(0, Tarea::count());
    }

    public function test_usuario_puede_eliminar_su_tarea_y_es_redirigido(): void
    {
        $user = User::factory()->create();
        $tarea = Tarea::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete(route('tareas.destroy', $tarea));

        $response->assertRedirect(route('tareas.index'))
            ->assertSessionHas('success', 'Tarea eliminada correctamente.');

        $this->assertSoftDeleted('tareas', [
            'id' => $tarea->id,
        ]);
    }

    public function test_envia_correo_al_usuario_al_crear_tarea(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'nombre' => 'Tarea de prueba',
            'descripcion' => 'Contenido de la tarea',
            'fecha_entrega' => now()->addWeek()->toDateString(),
        ];

        $response = $this->post(route('tareas.store'), $payload);

        $tarea = Tarea::first();

        $response->assertRedirect(route('tareas.show', $tarea))
            ->assertSessionHas('success', 'Tarea creada correctamente.');

        Mail::assertSent(TareaCreada::class, function (TareaCreada $mail) use ($user) {
            return $mail->hasTo($user->email)
                && $mail->tarea->nombre === 'Tarea de prueba';
        });
    }

    public function test_usa_el_correo_del_alumno_como_respaldo(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => '',
        ]);
        $alumno = Alumno::factory()->create([
            'user_id' => $user->id,
            'correo' => 'respaldo@example.com',
        ]);

        $this->actingAs($user);

        $payload = [
            'nombre' => 'Otra tarea',
            'descripcion' => 'Descripción alternativa',
            'fecha_entrega' => now()->addDays(3)->toDateString(),
        ];

        $this->post(route('tareas.store'), $payload);

        Mail::assertSent(TareaCreada::class, function (TareaCreada $mail) use ($alumno) {
            return $mail->hasTo($alumno->correo);
        });
    }
}
