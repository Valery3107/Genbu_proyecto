<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'mostrarFormulario'])->name('login');

Route::post('/login', [LoginController::class, 'autenticar'])->name('login.autenticar');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [RegistroController::class, 'validarCodigo'])->name('signup.validarCodigo');

Route::get('/perfil-persona', function () {
    return view('auth.perfil-persona');
})->name('perfil.crear');

Route::post('/perfil-persona', [RegistroController::class, 'guardarDatosPersonales'])->name('perfil.guardar');

Route::get('/viewpet', function () {
    return view('auth.viewpet');
})->name('viewpet');

Route::post('/viewpet', [MascotaController::class, 'guardar'])->name('mascota.guardar');

Route::get('/veterinario/registro', function () { 
    return view('auth.viewveterinary');
})->name('veterinario.form');

Route::post('/veterinario/registro', [RegistroController::class, 'guardarVeterinario'])->name('veterinario.guardar');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.solicitar');

 Route::post('/forgot-password', function () { 
    return 'Correo de recuperación enviado (falta implementar el envío real)'; 
})->name('password.enviar');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token, 'email' => request('email')]); 
})->name('password.reset');

Route::post('/reset-password', function () { 
    return 'Contraseña actualizada (falta implementar el guardado real)'; 
})->name('password.actualizar');

Route::middleware('verificar.sesion')->group(function () {
    Route::get('/dashboard/veterinario', [DashboardController::class, 'veterinario'])->middleware('verificar.rol:veterinario')->name('dashboard.veterinario');
    Route::get('/dashboard/secretaria', [DashboardController::class, 'secretaria'])->middleware('verificar.rol:secretaria')->name('dashboard.secretaria');
    Route::get('/dashboard/administrador', [DashboardController::class, 'administrador'])->middleware('verificar.rol:administrador')->name('dashboard.administrador');
    Route::post('/logout', [LoginController::class, 'cerrarSesion'])->name('logout');

    Route::get('/mascotas', [MascotaController::class, 'index'])->name('mascotas.index');
    Route::get('/mascotas/{id}/editar', [MascotaController::class, 'editar'])->name('mascotas.editar');
    Route::put('/mascotas/{id}', [MascotaController::class, 'actualizar'])->name('mascotas.actualizar');
    Route::delete('/mascotas/{id}', [MascotaController::class, 'eliminar'])->name('mascotas.eliminar');
});