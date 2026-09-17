<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Sesion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function mostrarFormulario()
    {
        return view('auth.pgc');
    }

    public function autenticar(Request $request)
    {
        // 1. Validar que llegaron los datos
        $datos = $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ]);

        // 2. Buscar el usuario por correo
        $usuario = Usuario::where('correo', $datos['correo'])->first();

        // 3. Verificar que existe, la contraseña coincide, y está activo
        if (! $usuario || ! Hash::check($datos['contrasena'], $usuario->contrasena)) {
            return back()->withErrors([
                'correo' => 'Correo o contraseña incorrectos.',
            ])->onlyInput('correo');
        }

        if ($usuario->estado !== 'activo') {
            return back()->withErrors([
                'correo' => 'Esta cuenta está inactiva. Contacta al administrador.',
            ])->onlyInput('correo');
        }

        // 4. Crear un registro de sesión (según tu modelo ER)
        $token = Str::random(60);
        Sesion::create([
            'id_usuario' => $usuario->id_usuario,
            'token' => $token,
            'fecha_inicio' => now(),
            'ip' => $request->ip(),
            'activa' => true,
        ]);

        // 5. Guardar datos básicos en la sesión de Laravel (para saber quién está logueado)
        $request->session()->put('usuario_id', $usuario->id_usuario);
        $request->session()->put('usuario_nombre', $usuario->nombre_completo);
        $request->session()->put('usuario_rol', $usuario->rol);

        // 6. Actualizar último acceso
        $usuario->ultimo_acceso = now();
        $usuario->save();

        // 7. Redirigir según el rol (tal como dice tu diagrama de secuencia)
        return match ($usuario->rol) {
            'veterinario' => redirect()->route('dashboard.veterinario'),
            'secretaria' => redirect()->route('dashboard.secretaria'),
            'administrador' => redirect()->route('dashboard.administrador'),
            default => redirect()->route('login'),
        };
    }
}