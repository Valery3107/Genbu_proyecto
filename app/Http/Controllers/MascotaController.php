<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Tutor;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    // CREATE
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
            'telefonoTutorMascota' => ['nullable', 'regex:/^(3\d{9}|60[1-8]\d{7})$/'],
        ], [
    'telefonoTutorMascota.regex' => 'Escribe un número de 10 dígitos: celular (3001234567) o fijo con 60 + indicativo (6011234567).',
]);

        $tutor = $this->buscarOCrearTutor(
            $datos['propietarioMascota'],
            $datos['telefonoTutorMascota'] ?? null
        );

        Mascota::create([
            'id_usuario' => $request->session()->get('usuario_id'),
            'id_tutor' => $tutor->id_tutor,
            'nombre' => $datos['nombreMascota'],
            'especie' => 'Canina',
            'fecha_nacimiento' => $datos['fechaNacimientoMascota'] ?? null,
            'raza' => $datos['razaMascota'],
            'sexo' => $datos['sexoMascota'],
            'color_pelaje' => $datos['colorPelajeMascota'] ?? null,
        ]);

        return redirect()->route('mascotas.index')->with('exito', 'Mascota registrada correctamente.');
    }

    // READ (listado)
    public function index()
    {
        $mascotas = Mascota::with('tutor')->orderBy('id_mascota', 'desc')->get();

        return view('dashboard.mascotas-index', [
            'mascotas' => $mascotas,
        ]);
    }

    // Formulario de edición, precargado
    public function editar($id)
    {
        $mascota = Mascota::with('tutor')->findOrFail($id);

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
            'telefonoTutorMascota' => ['nullable', 'regex:/^(3\d{9}|60[1-8]\d{7})$/'],
        ], [
    'telefonoTutorMascota.regex' => 'Escribe un número de 10 dígitos: celular (3001234567) o fijo con 60 + indicativo (6011234567).',
]);

        $idTutorAnterior = $mascota->id_tutor;

        $tutor = $this->buscarOCrearTutor(
            $datos['propietarioMascota'],
            $datos['telefonoTutorMascota'] ?? null
        );

        $mascota->update([
            'id_tutor' => $tutor->id_tutor,
            'nombre' => $datos['nombreMascota'],
            'fecha_nacimiento' => $datos['fechaNacimientoMascota'] ?? null,
            'raza' => $datos['razaMascota'],
            'sexo' => $datos['sexoMascota'],
            'color_pelaje' => $datos['colorPelajeMascota'] ?? null,
        ]);

        $this->limpiarTutorHuerfano($idTutorAnterior);

        return redirect()->route('mascotas.index')->with('exito', 'Mascota actualizada correctamente.');
    }

    // DELETE
    public function eliminar($id)
    {
        $mascota = Mascota::findOrFail($id);
        $idTutor = $mascota->id_tutor;

        $mascota->delete();

        $this->limpiarTutorHuerfano($idTutor);

        return redirect()->route('mascotas.index')->with('exito', 'Mascota eliminada correctamente.');
    }

    // Busca un tutor por nombre y teléfono; si no existe, lo crea
    private function buscarOCrearTutor(string $nombre, ?string $telefono): Tutor
    {
        $nombre = trim($nombre);
        $telefono = ($telefono === null || trim($telefono) === '') ? null : trim($telefono);

        $consulta = Tutor::where('nombre', $nombre);
        $telefono === null
            ? $consulta->whereNull('telefono')
            : $consulta->where('telefono', $telefono);

        return $consulta->first()
            ?? Tutor::create(['nombre' => $nombre, 'telefono' => $telefono]);
    }

    // Si el tutor se quedó sin mascotas, se elimina
    private function limpiarTutorHuerfano(?int $idTutor): void
    {
        if ($idTutor === null) {
            return;
        }

        if (! Mascota::where('id_tutor', $idTutor)->exists()) {
            Tutor::where('id_tutor', $idTutor)->delete();
        }
    }
}