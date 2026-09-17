<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    // CREATE (ya la tenías)
    public function guardar(Request $request)
    {
        if (! $request->session()->has('usuario_id')) {
            return redirect()->route('login')->withErrors([
                'correo' => 'Debes iniciar sesión para registrar una mascota.',
            ]);
        }

        $datos = $request->validate([
            'nombreMascota' => 'required|string|max:255',
            'fechaNacimientoMascota' => 'nullable|date',
            'razaMascota' => 'required|string|max:255',
            'sexoMascota' => 'required|string|max:255',
            'colorPelajeMascota' => 'nullable|string|max:255',
            'propietarioMascota' => 'required|string|max:255',
            'telefonoTutorMascota' => 'nullable|string|max:255',
        ]);

        Mascota::create([
            'id_usuario' => $request->session()->get('usuario_id'),
            'nombre' => $datos['nombreMascota'],
            'especie' => 'Canina',
            'fecha_nacimiento' => $datos['fechaNacimientoMascota'] ?? null,
            'raza' => $datos['razaMascota'],
            'sexo' => $datos['sexoMascota'],
            'color_pelaje' => $datos['colorPelajeMascota'] ?? null,
            'tutor' => $datos['propietarioMascota'],
            'telefono_tutor' => $datos['telefonoTutorMascota'] ?? null,
        ]);

        return redirect()->route('mascotas.index')->with('exito', 'Mascota registrada correctamente.');
    }

    // READ (listado)
    public function index()
    {
        $mascotas = Mascota::orderBy('id_mascota', 'desc')->get();

        return view('dashboard.mascotas-index', [
            'mascotas' => $mascotas,
        ]);
    }

    // Muestra el formulario de edición, precargado
    public function editar($id)
    {
        $mascota = Mascota::findOrFail($id);

        return view('auth.viewpet', [
            'mascota' => $mascota,
        ]);
    }

    // UPDATE
    public function actualizar(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);

        $datos = $request->validate([
            'nombreMascota' => 'required|string|max:255',
            'fechaNacimientoMascota' => 'nullable|date',
            'razaMascota' => 'required|string|max:255',
            'sexoMascota' => 'required|string|max:255',
            'colorPelajeMascota' => 'nullable|string|max:255',
            'propietarioMascota' => 'required|string|max:255',
            'telefonoTutorMascota' => 'nullable|string|max:255',
        ]);

        $mascota->update([
            'nombre' => $datos['nombreMascota'],
            'fecha_nacimiento' => $datos['fechaNacimientoMascota'] ?? null,
            'raza' => $datos['razaMascota'],
            'sexo' => $datos['sexoMascota'],
            'color_pelaje' => $datos['colorPelajeMascota'] ?? null,
            'tutor' => $datos['propietarioMascota'],
            'telefono_tutor' => $datos['telefonoTutorMascota'] ?? null,
        ]);

        return redirect()->route('mascotas.index')->with('exito', 'Mascota actualizada correctamente.');
    }

    // DELETE
    public function eliminar($id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->delete();

        return redirect()->route('mascotas.index')->with('exito', 'Mascota eliminada correctamente.');
    }
}