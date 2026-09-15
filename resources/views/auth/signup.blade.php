<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GENBU - Crear cuenta</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/genbu-variables.css') }}">
  <link rel="stylesheet" href="{{ asset('css/genbu-common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/genbu-signup.css') }}">
</head>
<body>
  <div class="bg-pattern"></div>

  <main class="page">
    <header class="header">
      <div class="logo-circle">
        <img src="{{ asset('images/logo.png') }}" alt="Logo GENBU">
      </div>
      <div class="headline">
        <h1>PARA CREAR UNA NUEVA CUENTA, VERIFICA QUE ERES EL PROPIETARIO</h1>
        <p>Ingresa tu codigo unico de acceso para continuar con el registro.</p>
      </div>
    </header>

    <section class="card card--signup" aria-label="Verificacion para crear cuenta">
      <span class="step-tag">Paso 1 de 2 - Verificación de identidad</span>

      <div class="content">
        <label class="field-label" for="accessCode">CÓDIGO ÚNICO DE ACCESO</label>
        <div class="input-group">
          <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M9 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" stroke="currentColor" stroke-width="1.8"/>
            <path d="M12 8h8v3h-2.2l-1.1 1.6h-1.9l-1 1.4H12V8Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M2 8a7 7 0 1 0 14 0A7 7 0 0 0 2 8Z" stroke="currentColor" stroke-width="1.8"/>
          </svg>
          <input id="accessCode" type="text" placeholder="Ej: GNB-2391-AX" autocomplete="off">
        </div>
        <p class="help-text">Si no recuerdas el código, contacta con soporte técnico para validarlo.</p>
      </div>

      <div class="actions actions--signup">
        <a class="btn--signup btn-primary" href="perfil-persona.html">CONTINUAR CREACIÓN DE CUENTA</a>
        <a class="btn--signup btn-secondary" href="pgc.html">VOLVER A INICIO DE SESIÓN</a>
      </div>
    </section>
  </main>
</body>
</html>