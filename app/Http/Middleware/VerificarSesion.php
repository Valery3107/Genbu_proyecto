<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarSesion
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('usuario_id')) {
            return redirect()->route('login')->withErrors([
                'correo' => 'Debes iniciar sesión para acceder a esta página.',
            ]);
        }

        return $next($request);
    }
}
