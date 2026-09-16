<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENBU - Recuperar contraseña</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/genbu-variables.css') }}">
<link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
</head>
<body>
  <div class="bg-pattern"></div>

  <main class="page-container">
    <header class="brand-header">
      <div class="logo-circle">
        <img src="{{ asset('images/logo.png') }}" alt="Logo GENBU">
      </div>
      <div class="title-box">
        <h1>¿OLVIDASTE TU CONTRASEÑA?</h1>
        <p>Enviaremos un correo para recuperarla.</p>
      </div>
    </header>

    <section class="recover-card" aria-label="Recuperar contraseña">
      <label class="field-label" for="email">CORREO ELECTRÓNICO:</label>

      <form method="post" action="{{ route('password.enviar') }}">
        @csrf
        <div class="input-group-custom">
          <input id="email" name="email" type="email" placeholder="Ingresa tu correo" required>
          <span class="input-icon" aria-hidden="true">✉</span>
        </div>

        <button type="submit" class="btn-primary-genbu">Recuperar contraseña</button>
      </form>

      <p class="hint-text">¿No has recibido ningún código?</p>
      <a href="{{ route('login') }}" class="btn-secondary-genbu">Inicio de sesión</a>
    </section>
  </main>
</body>
</html>
