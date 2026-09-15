<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GENBU - Perfil de la persona</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/genbu-variables.css">
  <link rel="stylesheet" href="css/genbu-common.css">
  <link rel="stylesheet" href="css/genbu-perfil.css">
</head>
<body>
  <div class="bg-pattern"></div>

  <main class="page page--perfil">
    <header class="header">
      <div class="logo-circle">
        <img src="images/logo.png" alt="Logo GENBU">
      </div>
      <div class="headline">
        <h1>Perfil de la persona</h1>
      </div>
    </header>

    <section class="card card--perfil" aria-label="Datos del perfil">
      <span class="step-tag">Paso 2 de 2 — Datos personales</span>

      <form class="form-grid" action="#" method="post">
        <div class="form-row">
          <label class="row-label" for="nombreCompleto">Nombre completo</label>
          <div class="row-input-wrap">
            <input id="nombreCompleto" name="nombreCompleto" type="text" autocomplete="name" placeholder="nombre y apellidos" required>
          </div>
          <div class="row-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke="currentColor" stroke-width="1.7"/><path d="M5 20a7 7 0 0 1 14 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
          </div>
        </div>

        <div class="form-row">
          <label class="row-label" for="correo">Correo electrónico</label>
          <div class="row-input-wrap">
            <input id="correo" name="correo" type="email" autocomplete="email" placeholder="correo@ejemplo.com" required>
          </div>
          <div class="row-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16v10H4V7Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>

        <div class="form-row">
          <label class="row-label" for="contrasena">Contraseña</label>
          <div class="row-input-wrap">
            <input id="contrasena" name="contrasena" type="password" autocomplete="new-password" placeholder="Minimo 8 caracteres" required>
          </div>
          <div class="row-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M12 15v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
          </div>
        </div>

        <div class="form-row">
          <label class="row-label" for="confirmarContrasena">Confirmar contraseña</label>
          <div class="row-input-wrap">
            <input id="confirmarContrasena" name="confirmarContrasena" type="password" autocomplete="new-password" required>
          </div>
          <div class="row-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M12 15v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
          </div>
        </div>

        <div class="form-row">
          <label class="row-label" for="documento">Número de documento</label>
          <div class="row-input-wrap">
            <input id="documento" name="documento" type="text" inputmode="numeric" autocomplete="off" placeholder="Sin puntos ni espacios" required>
          </div>
          <div class="row-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 9h4M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
          </div>
        </div>

        <div class="form-row">
          <label class="row-label" for="telefono">Teléfono de contacto</label>
          <div class="row-input-wrap">
            <input id="telefono" name="telefono" type="tel" autocomplete="tel" placeholder="Ej: 300 123 4567" required>
          </div>
          <div class="row-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none"><path d="M8 3h3l2 5-2 1a11 11 0 0 0 5 5l1-2 5 2v3a2 2 0 0 1-2 2A17 17 0 0 1 8 5a2 2 0 0 1 0-2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
          </div>
        </div>

        <div class="actions actions--perfil">
          <button type="submit" class="btn--perfil btn-primary">Crear cuenta</button>
          <a class="btn--perfil btn-secondary" href="viewVeterinary.html">Continuar para veterinario</a>
          <a class="btn--perfil btn-secondary" href="viewPet.html">Ir al perfil de la mascota</a>
        </div>
      </form>

      <a class="back-link" href="SignUp.html">Volver al paso anterior</a>
    </section>
  </main>
</body>
</html>