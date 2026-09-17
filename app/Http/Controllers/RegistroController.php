<?php

namespace App\Http\Controllers;

use App\Models\CodigoAcceso;
use App\Models\Usuario;
use App\Models\Veterinario;
use App\Models\SecretariaAuxiliar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    // PASO 1: valida el código de acceso (signup.blade.php)
    public function validarCodigo(Request $request)
    {
        $datos = $request->validate([
            'accessCode' => 'required|string',
        ]);

        $codigo = CodigoAcceso::where('codigo', $datos['accessCode'])
            ->where('usado', false)
            ->first();

        if (! $codigo) {
            return back()->withErrors([
                'accessCode' => 'Código inválido o ya utilizado.',
            ])->onlyInput('accessCode');
        }

        // Guardamos temporalmente en sesión: qué código es y qué rol asigna
        $request->session()->put('registro_codigo_id', $codigo->id_codigo);
        $request->session()->put('registro_rol', $codigo->rol_asignado);

        return redirect()->route('perfil.crear');
    }

    // PASO 2: datos personales (perfil-persona.blade.php)
    public function guardarDatosPersonales(Request $request)
    {
        // Si no viene de un código validado, no dejamos continuar
        if (! $request->session()->has('registro_codigo_id')) {
            return redirect()->route('signup')->withErrors([
                'accessCode' => 'Primero debes ingresar un código de acceso válido.',
            ]);
        }

        $datos = $request->validate([
            'nombreCompleto' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:8',
            'confirmarContrasena' => 'required|string',
            'documento' => 'required|string|unique:usuarios,numero_documento',
            'telefono' => 'nullable|string|max:255',
        ]);

        if ($datos['contrasena'] !== $datos['confirmarContrasena']) {
            return back()->withErrors([
                'confirmarContrasena' => 'Las contraseñas no coinciden.',
            ])->withInput();
        }

        $rol = $request->session()->get('registro_rol');

        // Si el código era de ROL VETERINARIO: guardamos los datos en sesión
        // y lo mandamos a la pantalla de datos profesionales (NO se crea la cuenta todavía)
        if ($rol === 'veterinario') {
            $request->session()->put('registro_datos_personales', [
                'nombre_completo' => $datos['nombreCompleto'],
                'correo' => $datos['correo'],
                'contrasena' => Hash::make($datos['contrasena']),
                'numero_documento' => $datos['documento'],
                'telefono' => $datos['telefono'],
            ]);

            return redirect()->route('veterinario.form');
        }

        // Si el código era de ROL SECRETARIA: se crea la cuenta de una vez
        $usuario = Usuario::create([
            'nombre_completo' => $datos['nombreCompleto'],
            'correo' => $datos['correo'],
            'contrasena' => Hash::make($datos['contrasena']),
            'numero_documento' => $datos['documento'],
            'telefono' => $datos['telefono'],
            'rol' => 'secretaria',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]);

        SecretariaAuxiliar::create([
            'id_usuario' => $usuario->id_usuario,
            'cargo' => 'Auxiliar administrativa',
            'horario_trabajo' => 'Por definir',
        ]);

        $this->marcarCodigoUsado($request);

        return redirect()->route('login')->with('exito', 'Cuenta creada correctamente. Ya puedes iniciar sesión.');
    }

    // PASO 3: datos profesionales, SOLO para el flujo de veterinario (viewveterinary.blade.php)
    public function guardarVeterinario(Request $request)
    {
        if (! $request->session()->has('registro_datos_personales') || $request->session()->get('registro_rol') !== 'veterinario') {
            return redirect()->route('signup')->withErrors([
                'accessCode' => 'Tu sesión de registro expiró. Empieza de nuevo.',
            ]);
        }

        $datos = $request->validate([
            'tarjetaProfesional' => 'required|string|unique:veterinarios,tarjeta_profesional',
            'especializacion' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'consultorio' => 'required|string|max:255',
            'horario' => 'required|string|max:255',
            'estadoActual' => 'nullable|string|max:255',
            'residencia' => 'nullable|string|max:255',
        ]);

        $datosPersonales = $request->session()->get('registro_datos_personales');

        $usuario = Usuario::create(array_merge($datosPersonales, [
            'rol' => 'veterinario',
            'estado' => 'activo',
            'fecha_registro' => now(),
        ]));

        Veterinario::create([
            'id_usuario' => $usuario->id_usuario,
            'tarjeta_profesional' => $datos['tarjetaProfesional'],
            'especializacion' => $datos['especializacion'],
            'cargo' => $datos['cargo'],
            'numero_consultorio' => $datos['consultorio'],
            'horario_trabajo' => $datos['horario'],
            'estado_actual' => $datos['estadoActual'],
            'lugar_residencia' => $datos['residencia'],
        ]);

        $this->marcarCodigoUsado($request);

        return redirect()->route('login')->with('exito', 'Cuenta de veterinario creada correctamente. Ya puedes iniciar sesión.');
    }

    // Función auxiliar: marca el código como usado y limpia la sesión temporal
    private function marcarCodigoUsado(Request $request)
    {
        $codigo = CodigoAcceso::find($request->session()->get('registro_codigo_id'));
        if ($codigo) {
            $codigo->usado = true;
            $codigo->fecha_uso = now();
            $codigo->save();
        }

        $request->session()->forget(['registro_codigo_id', 'registro_rol', 'registro_datos_personales']);
    }
}
