<?php

namespace Tests\Feature;

use App\Models\CodigoAcceso;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogicaNegocioTest extends TestCase
{
    use RefreshDatabase;

    // ===== 1. VALIDACIÓN DE CÓDIGO DE ACCESO =====

    public function test_codigo_valido_sin_usar_permite_continuar(): void
    {
        CodigoAcceso::create([
            'codigo' => 'TEST-001',
            'rol_asignado' => 'veterinario',
            'usado' => false,
            'fecha_generacion' => now(),
        ]);

        $response = $this->post('/signup', ['accessCode' => 'TEST-001']);

        $response->assertRedirect(route('perfil.crear'));
        $response->assertSessionHas('registro_codigo_id');
    }

    public function test_codigo_ya_usado_no_permite_continuar(): void
    {
        CodigoAcceso::create([
            'codigo' => 'TEST-002',
            'rol_asignado' => 'secretaria',
            'usado' => true,
            'fecha_generacion' => now(),
            'fecha_uso' => now(),
        ]);

        $response = $this->post('/signup', ['accessCode' => 'TEST-002']);

        $response->assertSessionHasErrors('accessCode');
    }

    public function test_codigo_inexistente_no_permite_continuar(): void
    {
        $response = $this->post('/signup', ['accessCode' => 'NO-EXISTE-999']);

        $response->assertSessionHasErrors('accessCode');
    }

    // ===== 2. VALIDACIÓN DE CONTRASEÑA EN REGISTRO =====

    public function test_contrasenas_distintas_muestran_error(): void
    {
        $codigo = CodigoAcceso::create([
            'codigo' => 'TEST-003',
            'rol_asignado' => 'secretaria',
            'usado' => false,
            'fecha_generacion' => now(),
        ]);

        $response = $this->withSession([
            'registro_codigo_id' => $codigo->id_codigo,
            'registro_rol' => 'secretaria',
        ])->post('/perfil-persona', [
            'nombreCompleto' => 'Prueba Test',
            'correo' => 'prueba.test@genbu.com',
            'contrasena' => 'password123',
            'confirmarContrasena' => 'password456',
            'documento' => '9999999999',
            'telefono' => '3000000000',
        ]);

        $response->assertSessionHasErrors('confirmarContrasena');
    }

    public function test_contrasena_menor_a_8_caracteres_muestra_error(): void
    {
        $codigo = CodigoAcceso::create([
            'codigo' => 'TEST-004',
            'rol_asignado' => 'secretaria',
            'usado' => false,
            'fecha_generacion' => now(),
        ]);

        $response = $this->withSession([
            'registro_codigo_id' => $codigo->id_codigo,
            'registro_rol' => 'secretaria',
        ])->post('/perfil-persona', [
            'nombreCompleto' => 'Prueba Test',
            'correo' => 'prueba2.test@genbu.com',
            'contrasena' => '123',
            'confirmarContrasena' => '123',
            'documento' => '9999999998',
            'telefono' => '3000000000',
        ]);

        $response->assertSessionHasErrors('contrasena');
    }

    // ===== 3. LOGIN =====

    public function test_login_credenciales_correctas_redirige_al_dashboard_correcto(): void
    {
        Usuario::create([
            'nombre_completo' => 'Test Vet',
            'correo' => 'test.vet@genbu.com',
            'contrasena' => Hash::make('clave1234'),
            'numero_documento' => '8888888888',
            'telefono' => '3000000000',
            'rol' => 'veterinario',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        $response = $this->post('/login', [
            'correo' => 'test.vet@genbu.com',
            'contrasena' => 'clave1234',
        ]);

        $response->assertRedirect(route('dashboard.veterinario'));
    }

    public function test_login_con_contrasena_incorrecta_es_rechazado(): void
    {
        Usuario::create([
            'nombre_completo' => 'Test Vet 2',
            'correo' => 'test.vet2@genbu.com',
            'contrasena' => Hash::make('claveReal123'),
            'numero_documento' => '7777777777',
            'telefono' => '3000000000',
            'rol' => 'veterinario',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        $response = $this->post('/login', [
            'correo' => 'test.vet2@genbu.com',
            'contrasena' => 'claveEquivocada',
        ]);

        $response->assertSessionHasErrors('correo');
    }

    // ===== 4. REGISTRO DE MASCOTA EXIGE SESIÓN =====

    public function test_registrar_mascota_sin_sesion_activa_es_rechazado(): void
    {
        $response = $this->post('/viewpet', [
            'nombreMascota' => 'Rex',
            'razaMascota' => 'Labrador',
            'sexoMascota' => 'Macho',
            'propietarioMascota' => 'Juan Perez',
        ]);

        $response->assertRedirect(route('login'));
    }
}