<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GENBU — Perfil de la mascota</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/genbu-variables.css') }}">
  <link rel="stylesheet" href= "{{ asset('css/genbu-common.css') }}">
  <link rel="stylesheet" href=" {{ asset('css/genbu-viewpet.css') }}">
</head>
<body class="page-viewpet">
  <div class="bg-pattern" aria-hidden="true"></div>

  <main class="page page--pet">
    <header class="header">
      <a href="{{ route('login') }}" class="logo-circle" aria-label="Ir al inicio de sesión">
        <img src=" {{ asset('images/logo.png') }}" alt="">
      </a>
      <div class="headline">
        <h1>Perfil de la mascota</h1>
      </div>
    </header>

    <div class="pet-layout">
      <section class="pet-form-panel" aria-labelledby="pet-form-title">
        <h2 id="pet-form-title" class="visually-hidden">Datos de la mascota</h2>

        <form class="pet-form" id="pet-profile-form" action="{{ route('mascota.guardar') }}" method="post">
         @csrf 
          <div class="pet-row">
            <label class="pet-label" for="nombreMascota">
              <img class="pet-label-icon" src="{{ asset('images/paw.png') }}" width="26" height="26" alt="" aria-hidden="true">
              <span class="pet-label-text">Nombre</span>
            </label>
            <div class="pet-input-wrap">
              <input id="nombreMascota" name="nombreMascota" type="text" autocomplete="nickname" placeholder="Ej. Mia" autofocus>
            </div>
          </div>

          <div class="pet-row">
            <label class="pet-label" for="fechaNacimientoMascota">
              <img class="pet-label-icon" src="{{ asset('images/time.png') }}" width="26" height="26" alt="" aria-hidden="true">
              <span class="pet-label-text">Fecha de nacimiento</span>
            </label>
            <div class="pet-input-wrap">
              <input id="fechaNacimientoMascota" name="fechaNacimientoMascota" type="date" autocomplete="off">
            </div>
          </div>

          <div class="pet-row">
            <label class="pet-label" for="razaMascota">
              <img class="pet-label-icon" src="{{ asset('images/dog.png') }}" width="26" height="26" alt="" aria-hidden="true">
              <span class="pet-label-text">Raza</span>
            </label>
            <div class="pet-input-wrap">
              <input id="razaMascota" name="razaMascota" type="text" autocomplete="off" placeholder="Ej. Bichón frisé">
            </div>
          </div>

          <div class="pet-row">
            <label class="pet-label" for="sexoMascota">
              <img class="pet-label-icon" src="{{ asset('images/female.png') }}" width="26" height="26" alt="" aria-hidden="true">
              <span class="pet-label-text">Sexo</span>
            </label>
            <div class="pet-input-wrap">
              <input id="sexoMascota" name="sexoMascota" type="text" autocomplete="off" placeholder="Ej. Hembra">
            </div>
          </div>

          <div class="pet-row">
            <label class="pet-label" for="propietarioMascota">
              <img class="pet-label-icon" src="{{ asset('images/user.png') }}" width="26" height="26" alt="" aria-hidden="true">
              <span class="pet-label-text">Propietario</span>
            </label>
            <div class="pet-input-wrap">
              <input id="propietarioMascota" name="propietarioMascota" type="text" autocomplete="name" placeholder="Nombre del tutor">
            </div>
          </div>
        </form>
      </section>

      <aside class="pet-sidebar" aria-label="Foto y accesos rápidos">
        <div class="pet-photo-stack">
          <div class="pet-photo-wrap">
            <img class="pet-photo" src="{{ asset('images/Mia.png') }}" alt="Fotografía de la mascota">
          </div>
          <img class="pet-photo-bone" src="{{ asset('images/hueso.png') }}" alt="" aria-hidden="true">
        </div>

        <div class="pet-quick-actions">
          <button type="button" class="pet-btn-quick">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
              <rect x="9" y="3" width="6" height="4" rx="1"/>
              <path d="M9 12h6M12 9v6"/>
            </svg>
            Historial médico
          </button>
          <button type="button" class="pet-btn-quick">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <circle cx="11" cy="11" r="7"/>
              <path d="M21 21l-4.35-4.35"/>
            </svg>
            Ver diagnóstico
          </button>
        </div>
      </aside>
    </div>

    <footer class="pet-footer-actions">
      <button type="button" class="pet-btn-footer">Editar perfil</button>
      <button type="submit" form="pet-profile-form" class="pet-btn-footer">Guardar cambios</button>
      <button type="button" class="pet-btn-footer">Agregar mascota</button>
      <button type="button" class="pet-btn-footer pet-btn-footer--danger">Eliminar perfil</button>
    </footer>
  </main>

  <script>
    document.getElementById("pet-profile-form").addEventListener("submit", function (e) {
      e.preventDefault();
    });
  </script>
</body>
</html>