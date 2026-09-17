<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function guardar(Request $request)
    {
        // 1. Verificar que haya una sesión activa (alguien logueado)
        if (! $request->session()->has('usuario_id')) {
            return redirect()->route('login')->withErrors([
                'correo' => 'Debes iniciar sesión para registrar una mascota.',
            ]);
        }

        // 2. Validar los datos del formulario
        $datos = $request->validate([
            'nombreMascota' => 'required|string|max:255',
            'fechaNacimientoMascota' => 'nullable|date',
            'razaMascota' => 'required|string|max:255',
            'sexoMascota' => 'required|string|max:255',
            'colorPelajeMascota' => 'nullable|string|max:255',
            'propietarioMascota' => 'required|string|max:255',
            'telefonoTutorMascota' => 'nullable|string|max:255',
        ]);

        // 3. Guardar la mascota, vinculada al usuario que la registra
        Mascota::create([
            'id_usuario' => $request->session()->get('usuario_id'),
            'nombre' => $datos['nombreMascota'],
            'fecha_nacimiento' => $datos['fechaNacimientoMascota'] ?? null,
            'raza' => $datos['razaMascota'],
            'sexo' => $datos['sexoMascota'],
            'especie' => 'Canina', 
            'color_pelaje' => $datos['colorPelajeMascota'] ?? null,
            'tutor' => $datos['propietarioMascota'],
            'telefono_tutor' => $datos['telefonoTutorMascota'] ?? null,
        ]);

        // 4. Redirigir con mensaje de éxito
        return back()->with('exito', 'Mascota registrada correctamente.');
    }
}
