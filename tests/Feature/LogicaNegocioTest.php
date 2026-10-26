<?php

namespace Tests\Feature;

use App\Models\CodigoAcceso;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

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

    // ===== 5. CRUD DE MASCOTA =====

public function test_registrar_mascota_con_sesion_activa_guarda_correctamente(): void
{
    $usuario = Usuario::create([
        'nombre_completo' => 'Test Vet CRUD',
        'correo' => 'test.vet.crud@genbu.com',
        'contrasena' => Hash::make('clave1234'),
        'numero_documento' => '6666666666',
        'telefono' => '3000000000',
        'rol' => 'veterinario',
        'estado' => 'activo',
        'fecha_registro' => now(),
    ]);

    $response = $this->withSession([
        'usuario_id' => $usuario->id_usuario,
        'usuario_nombre' => $usuario->nombre_completo,
        'usuario_rol' => $usuario->rol,
    ])->post('/viewpet', [
        'nombreMascota' => 'Rex',
        'fechaNacimientoMascota' => '2023-01-01',
        'razaMascota' => 'Labrador',
        'sexoMascota' => 'Macho',
        'colorPelajeMascota' => 'Dorado',
        'propietarioMascota' => 'Juan Perez',
        'telefonoTutorMascota' => '3001112233',
    ]);

    $response->assertRedirect(route('mascotas.index'));
    $this->assertDatabaseHas('mascotas', ['nombre' => 'Rex', 'raza' => 'Labrador']);
}

public function test_actualizar_mascota_modifica_los_datos_correctamente(): void
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Test Sec CRUD',
            'correo' => 'test.sec.crud@genbu.com',
            'contrasena' => Hash::make('clave1234'),
            'numero_documento' => '5555555555',
            'telefono' => '3000000000',
            'rol' => 'secretaria',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        $tutor = \App\Models\Tutor::create(['nombre' => 'Pedro Gomez']);

        $mascota = \App\Models\Mascota::create([
            'id_usuario' => $usuario->id_usuario,
            'id_tutor' => $tutor->id_tutor,
            'nombre' => 'Firulais',
            'especie' => 'Canina',
            'raza' => 'Criollo',
            'sexo' => 'Macho',
        ]);

        $response = $this->withSession([
            'usuario_id' => $usuario->id_usuario,
            'usuario_nombre' => $usuario->nombre_completo,
            'usuario_rol' => $usuario->rol,
        ])->put("/mascotas/{$mascota->id_mascota}", [
            'nombreMascota' => 'Firulais',
            'razaMascota' => 'Poodle',
            'sexoMascota' => 'Macho',
            'propietarioMascota' => 'Pedro Gomez',
        ]);

        $response->assertRedirect(route('mascotas.index'));
        $this->assertDatabaseHas('mascotas', ['id_mascota' => $mascota->id_mascota, 'raza' => 'Poodle']);
    }

    public function test_eliminar_mascota_la_remueve_de_la_base_de_datos(): void
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Test Sec CRUD 2',
            'correo' => 'test.sec.crud2@genbu.com',
            'contrasena' => Hash::make('clave1234'),
            'numero_documento' => '4444444444',
            'telefono' => '3000000000',
            'rol' => 'secretaria',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        $tutor = \App\Models\Tutor::create(['nombre' => 'Ana Diaz']);

        $mascota = \App\Models\Mascota::create([
            'id_usuario' => $usuario->id_usuario,
            'id_tutor' => $tutor->id_tutor,
            'nombre' => 'Luna',
            'especie' => 'Canina',
            'raza' => 'Criollo',
            'sexo' => 'Hembra',
        ]);

        $response = $this->withSession([
            'usuario_id' => $usuario->id_usuario,
            'usuario_nombre' => $usuario->nombre_completo,
            'usuario_rol' => $usuario->rol,
        ])->delete("/mascotas/{$mascota->id_mascota}");

        $response->assertRedirect(route('mascotas.index'));
        $this->assertDatabaseMissing('mascotas', ['id_mascota' => $mascota->id_mascota]);
        $this->assertDatabaseMissing('tutores', ['id_tutor' => $tutor->id_tutor]);
    }

    public function test_dos_mascotas_del_mismo_tutor_comparten_un_solo_registro_de_tutor(): void
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Test Vet Tutor',
            'correo' => 'test.vet.tutor@genbu.com',
            'contrasena' => Hash::make('clave1234'),
            'numero_documento' => '3333333333',
            'telefono' => '3000000000',
            'rol' => 'veterinario',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        $sesion = [
            'usuario_id' => $usuario->id_usuario,
            'usuario_nombre' => $usuario->nombre_completo,
            'usuario_rol' => $usuario->rol,
        ];

        foreach (['Rex', 'Luna'] as $nombre) {
            $this->withSession($sesion)->post('/viewpet', [
                'nombreMascota' => $nombre,
                'razaMascota' => 'Labrador',
                'sexoMascota' => 'Macho',
                'propietarioMascota' => 'Juan Perez',
                'telefonoTutorMascota' => '3001112233',
            ])->assertRedirect(route('mascotas.index'));
        }

        $this->assertDatabaseCount('tutores', 1);
        $this->assertDatabaseCount('mascotas', 2);
    }

    public static function telefonosInvalidosTutor(): array
    {
        return [
            'con letras'             => ['300abc1234'],
            'once digitos'           => ['30012345678'],
            'con espacios'           => ['300 123 4567'],
            'nueve digitos'          => ['311111111'],
            'diez digitos sin forma' => ['1234567890'],
            'indicativo inexistente' => ['6091234567'],
        ];
    }

#[DataProvider('telefonosInvalidosTutor')]
public function test_telefono_invalido_del_tutor_es_rechazado(string $telefono): void
{
    $usuario = Usuario::create([
        'nombre_completo' => 'Test Vet Telefono',
        'correo' => 'test.vet.telefono@genbu.com',
        'contrasena' => Hash::make('clave1234'),
        'numero_documento' => '2222222222',
        'telefono' => '3000000000',
        'rol' => 'veterinario',
        'estado' => 'activo',
        'fecha_registro' => now(),
    ]);

    $response = $this->withSession([
        'usuario_id' => $usuario->id_usuario,
        'usuario_nombre' => $usuario->nombre_completo,
        'usuario_rol' => $usuario->rol,
    ])->post('/viewpet', [
        'nombreMascota' => 'Rex',
        'razaMascota' => 'Labrador',
        'sexoMascota' => 'Macho',
        'propietarioMascota' => 'Juan Perez',
        'telefonoTutorMascota' => $telefono,
    ]);

    $response->assertSessionHasErrors('telefonoTutorMascota');
    $this->assertDatabaseCount('mascotas', 0);
    $this->assertDatabaseCount('tutores', 0);
}
// ===== VALIDACIÓN DE DOCUMENTO Y TELÉFONO EN REGISTRO DE USUARIO =====

    #[DataProvider('proveedorDocumentosInvalidos')]
public function test_documento_invalido_de_usuario_es_rechazado(string $documentoInvalido): void
    {
        $codigo = CodigoAcceso::create([
            'codigo' => 'TEST-DOC-' . uniqid(),
            'rol_asignado' => 'secretaria',
            'usado' => false,
            'fecha_generacion' => now(),
        ]);

        $response = $this->withSession([
            'registro_codigo_id' => $codigo->id_codigo,
            'registro_rol' => 'secretaria',
        ])->post('/perfil-persona', [
            'nombreCompleto' => 'Prueba Doc',
            'correo' => 'usuario.doc@genbu.com',
            'contrasena' => 'password123',
            'confirmarContrasena' => 'password123',
            'documento' => $documentoInvalido,
            'telefono' => '3001234567',
        ]);

        $response->assertSessionHasErrors('documento');
    }

    public static function proveedorDocumentosInvalidos(): array
    {
        return [
            'con letras' => ['12345ABC'],
            'muy corto (menos de 6)' => ['12345'],
            'muy largo (mas de 10)' => ['12345678901'],
            'con puntos' => ['1.234.567'],
        ];
    }

    #[DataProvider('proveedorTelefonosInvalidosUsuario')]
public function test_telefono_invalido_de_usuario_es_rechazado(string $telefonoInvalido): void

   

    {
        $codigo = CodigoAcceso::create([
            'codigo' => 'TEST-TEL-' . uniqid(),
            'rol_asignado' => 'secretaria',
            'usado' => false,
            'fecha_generacion' => now(),
        ]);

        $response = $this->withSession([
            'registro_codigo_id' => $codigo->id_codigo,
            'registro_rol' => 'secretaria',
        ])->post('/perfil-persona', [
            'nombreCompleto' => 'Prueba Tel',
            'correo' => 'usuario.tel@genbu.com',
            'contrasena' => 'password123',
            'confirmarContrasena' => 'password123',
            'documento' => '1020304050',
            'telefono' => $telefonoInvalido,
        ]);

        $response->assertSessionHasErrors('telefono');
    }

    public static function proveedorTelefonosInvalidosUsuario(): array
{
    return [
        'con letras'           => ['300abc1234'],
        'once digitos'         => ['30012345678'],
        'indicativo inexistente' => ['6091234567'], // Asegúrate de que esto no sea null
    ];
}

    public static function telefonosValidos(): array
    {
        return [
            'celular 300'             => ['3001112233'],
            'fijo Cundinamarca (601)' => ['6011234567'],
        ];
    }

    #[DataProvider('telefonosValidos')]
    public function test_telefonos_validos_segun_plan_nacional_son_aceptados(string $telefono): void
    {
        $codigo = CodigoAcceso::create([
            'codigo' => 'TEST-TEL-OK-' . uniqid(),
            'rol_asignado' => 'secretaria',
            'usado' => false,
            'fecha_generacion' => now(),
        ]);

        $response = $this->withSession([
            'registro_codigo_id' => $codigo->id_codigo,
            'registro_rol' => 'secretaria',
        ])->post('/perfil-persona', [
            'nombreCompleto' => 'Prueba Tel OK',
            'correo' => 'usuario.ok.' . uniqid() . '@genbu.com',
            'contrasena' => 'password123',
            'confirmarContrasena' => 'password123',
            'documento' => '1020304050',
            'telefono' => $telefono,
        ]);

        $response->assertSessionHasNoErrors();
    }
   

public static function telefonosValidosTutor(): array
{
    return [
        'celular'                 => ['3001112233'],
        'fijo Cundinamarca (601)' => ['6011234567'],
    ];
}

#[DataProvider('telefonosValidosTutor')]
public function test_telefono_valido_del_tutor_es_aceptado(string $telefono): void
{
    $usuario = Usuario::create([
        'nombre_completo' => 'Test Vet Telefono OK',
        'correo' => 'test.vet.telefono.ok@genbu.com',
        'contrasena' => Hash::make('clave1234'),
        'numero_documento' => '2222222223',
        'telefono' => '3000000000',
        'rol' => 'veterinario',
        'estado' => 'activo',
        'fecha_registro' => now(),
    ]);

    $response = $this->withSession([
        'usuario_id' => $usuario->id_usuario,
        'usuario_nombre' => $usuario->nombre_completo,
        'usuario_rol' => $usuario->rol,
    ])->post('/viewpet', [
        'nombreMascota' => 'Rex',
        'razaMascota' => 'Labrador',
        'sexoMascota' => 'Macho',
        'propietarioMascota' => 'Juan Perez',
        'telefonoTutorMascota' => $telefono,
    ]);

    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('tutores', ['telefono' => $telefono]);
}
public function test_actualizar_mascota_con_telefono_invalido_del_tutor_es_rechazado(): void
{
    $usuario = Usuario::create([
        'nombre_completo' => 'Test Sec Telefono Update',
        'correo' => 'test.sec.telefono.update@genbu.com',
        'contrasena' => Hash::make('clave1234'),
        'numero_documento' => '2222222225',
        'telefono' => '3000000000',
        'rol' => 'secretaria',
        'estado' => 'activo',
        'fecha_registro' => now(),
    ]);

    $tutor = \App\Models\Tutor::create(['nombre' => 'Pedro Gomez', 'telefono' => '3001112233']);

    $mascota = \App\Models\Mascota::create([
        'id_usuario' => $usuario->id_usuario,
        'id_tutor' => $tutor->id_tutor,
        'nombre' => 'Firulais',
        'especie' => 'Canina',
        'raza' => 'Criollo',
        'sexo' => 'Macho',
    ]);

    $response = $this->withSession([
        'usuario_id' => $usuario->id_usuario,
        'usuario_nombre' => $usuario->nombre_completo,
        'usuario_rol' => $usuario->rol,
    ])->put("/mascotas/{$mascota->id_mascota}", [
        'nombreMascota' => 'Firulais',
        'razaMascota' => 'Poodle',
        'sexoMascota' => 'Macho',
        'propietarioMascota' => 'Pedro Gomez',
        'telefonoTutorMascota' => '12345',
    ]);

    $response->assertSessionHasErrors('telefonoTutorMascota');
    $this->assertDatabaseHas('mascotas', ['id_mascota' => $mascota->id_mascota, 'raza' => 'Criollo']);
}
}