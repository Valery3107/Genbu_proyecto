<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Usuario;
use App\Models\Veterinario;
use App\Models\CodigoAcceso;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function veterinario(Request $request)
    {
        return view('dashboard.dashboard-veterinario', [
            'nombre' => $request->session()->get('usuario_nombre'),
            'totalMascotas' => Mascota::count(),
        ]);
    }

    public function secretaria(Request $request)
    {
        return view('dashboard.dashboard-secretaria', [
            'nombre' => $request->session()->get('usuario_nombre'),
            'totalMascotas' => Mascota::count(),
        ]);
    }

    public function administrador(Request $request)
    {
        return view('dashboard.dashboard-administrador', [
            'nombre' => $request->session()->get('usuario_nombre'),
            'totalUsuarios' => Usuario::count(),
            'totalVeterinarios' => Veterinario::count(),
            'codigosDisponibles' => CodigoAcceso::where('usado', false)->count(),
            'totalMascotas' => Mascota::count(),
        ]);
    }
}
