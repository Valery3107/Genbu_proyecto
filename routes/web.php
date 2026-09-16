<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.pgc');
})->name('login');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::get('/perfil-persona', function () {
    return view('auth.perfil-persona');
})->name('perfil.crear');

Route::post('/perfil-persona', function () {
    return 'Formulario recibido (falta guardar en base de datos)';
})->name('perfil.guardar');

Route::get('/viewpet', function () {
    return view('auth.viewpet');
})->name('viewpet');

Route::post('/viewpet', function () {
    return 'Formulario de mascota recibido (falta guardar en base de datos)';
})->name('mascota.guardar');

Route::get('/veterinario/registro', function () { 
    return view('auth.viewveterinary');
})->name('veterinario.form');

 Route::post('/veterinario/registro', function () { 
    return redirect()->route('login');
})->name('veterinario.guardar');

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

 Route::get('/dashboard/veterinario', function () { 
    return view('dashboard.dashboard-veterinario'); 
})->name('dashboard.veterinario');

Route::get('/dashboard/secretaria', function () {
    return view('dashboard.dashboard-secretaria');
})->name('dashboard.secretaria');

Route::get('/dashboard/administrador', function () {
    return view('dashboard.dashboard-administrador');
})->name('dashboard.administrador');