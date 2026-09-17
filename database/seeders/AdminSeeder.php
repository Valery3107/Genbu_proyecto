<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\CodigoAcceso;
use App\Models\Veterinario;
use App\Models\SecretariaAuxiliar;
use App\Models\Mascota;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. El primer Administrador (sin pasar por signup, como ya vimos que debía ser)
        $admin = Usuario::create([
            'nombre_completo' => 'Admin GENBU',
            'correo' => 'admin@genbu.com',
            'contrasena' => Hash::make('admin1234'),
            'numero_documento' => '1000000001',
            'telefono' => '3000000001',
            'rol' => 'administrador',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        // 2. Dos códigos de acceso, generados por ese Administrador
        CodigoAcceso::create([
            'codigo' => 'GNB-VET-001',
            'rol_asignado' => 'veterinario',
            'usado' => false,
            'fecha_generacion' => now(),
            'id_administrador' => $admin->id_usuario,
        ]);

        CodigoAcceso::create([
            'codigo' => 'GNB-SEC-001',
            'rol_asignado' => 'secretaria',
            'usado' => false,
            'fecha_generacion' => now(),
            'id_administrador' => $admin->id_usuario,
        ]);

        // 3. Un Veterinario de ejemplo (usuario base + su perfil profesional)
        $usuarioVet = Usuario::create([
            'nombre_completo' => 'Dra. Valentina Torres',
            'correo' => 'valentina.torres@genbu.com',
            'contrasena' => Hash::make('vet12345'),
            'numero_documento' => '1000000002',
            'telefono' => '3000000002',
            'rol' => 'veterinario',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        $veterinario = Veterinario::create([
            'id_usuario' => $usuarioVet->id_usuario,
            'tarjeta_profesional' => 'TP-45210',
            'especializacion' => 'Dermatología',
            'cargo' => 'Médico tratante',
            'numero_consultorio' => '3',
            'horario_trabajo' => 'Lun-Vie 8:00 - 18:00',
            'estado_actual' => 'Activo en planta',
            'lugar_residencia' => 'Ubaté, Cundinamarca',
        ]);

        // 4. Una Secretaria de ejemplo
        $usuarioSec = Usuario::create([
            'nombre_completo' => 'Camila Rojas',
            'correo' => 'camila.rojas@genbu.com',
            'contrasena' => Hash::make('sec12345'),
            'numero_documento' => '1000000003',
            'telefono' => '3000000003',
            'rol' => 'secretaria',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        SecretariaAuxiliar::create([
            'id_usuario' => $usuarioSec->id_usuario,
            'cargo' => 'Auxiliar administrativa',
            'horario_trabajo' => 'Lun-Sab 7:00 - 15:00',
        ]);

        // 5. Dos mascotas de ejemplo, registradas por la secretaria
        Mascota::create([
            'id_usuario' => $usuarioSec->id_usuario,
            'nombre' => 'Mia',
            'especie' => 'Canina',
            'raza' => 'Bichón frisé',
            'sexo' => 'Hembra',
            'fecha_nacimiento' => '2023-04-12',
            'tutor' => 'Laura Gómez',
            'telefono_tutor' => '3111111111',
        ]);

        Mascota::create([
            'id_usuario' => $usuarioSec->id_usuario,
            'nombre' => 'Rocco',
            'especie' => 'Canina',
            'raza' => 'Labrador',
            'sexo' => 'Macho',
            'fecha_nacimiento' => '2022-01-20',
            'tutor' => 'Andrés Pérez',
            'telefono_tutor' => '3222222222',
        ]);
    }
}
