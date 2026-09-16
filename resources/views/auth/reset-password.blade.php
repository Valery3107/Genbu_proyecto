<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENBU - Nueva contraseña</title>
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
        <h1>CREA TU NUEVA CONTRASEÑA</h1>
        <p>Ingresa una contraseña nueva para tu cuenta.</p>
      </div>
    </header>

    <section class="recover-card" aria-label="Nueva contraseña">

      @if ($errors->any())
        <div class="alert alert-danger" role="alert" style="margin-bottom: 16px;">
          <ul style="margin: 0; padding-left: 18px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="post" action="{{ route('password.actualizar') }}">
        @csrf

        {{-- El token viene en la URL del enlace que le llegó al correo --}}
        <input type="hidden" name="token" value="{{ $token ?? '' }}">

        <label class="field-label" for="email">CORREO ELECTRÓNICO:</label>
        <div class="input-group-custom">
          <input id="email" name="email" type="email" value="{{ old('email', $email ?? '') }}" placeholder="Tu correo registrado" required readonly>
          <span class="input-icon" aria-hidden="true">✉</span>
        </div>

        <label class="field-label" for="password" style="margin-top: 14px;">NUEVA CONTRASEÑA:</label>
        <div class="input-group-custom">
          <input id="password" name="password" type="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
          <img class="input-icon" src="{{ asset('images/candado.png') }}" width="20" height="20" alt="" aria-hidden="true">
        </div>

        <label class="field-label" for="password_confirmation" style="margin-top: 14px;">CONFIRMAR CONTRASEÑA:</label>
        <div class="input-group-custom">
          <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Repite la contraseña" minlength="8" required>
          <img class="input-icon" src="{{ asset('images/candado.png') }}" width="20" height="20" alt="" aria-hidden="true">
        </div>

        <button type="submit" class="btn-primary-genbu" style="margin-top: 20px;">Actualizar contraseña</button>
      </form>

      <p class="hint-text">¿Recordaste tu contraseña?</p>
      <a href="{{ route('login') }}" class="btn-secondary-genbu">Inicio de sesión</a>
    </section>
  </main>
</body>
</html>