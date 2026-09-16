<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GENBU - Perfil del médico veterinario</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/genbu-variables.css') }}">
  <link rel="stylesheet" href="{{ asset('css/genbu-common.css') }}">
  <link rel="stylesheet" href="{{ asset('css/genbu-signup.css') }}">
  <style>
    /* Vista veterinario: reutiliza tokens; filas etiqueta + campo (sin columna de icono) */
    .page--vet {
      gap: 20px;
    }

    .headline h1 {
      font-size: clamp(26px, 3.6vw, 40px);
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }

    .card--vet {
      width: 100%;
      max-width: 720px;
      margin: 0 auto;
      background: rgba(248, 250, 249, 0.94);
      border: 1px solid rgba(45, 74, 66, 0.12);
      border-radius: 22px;
      padding: 28px 22px 32px;
      box-shadow: 0 8px 22px rgba(45, 74, 66, 0.1);
    }

    .vet-form {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    .vet-row {
      display: grid;
      grid-template-columns: minmax(200px, 280px) 1fr;
      align-items: stretch;
      gap: 12px;
    }

    .vet-label {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      background: var(--etiqueta-fila-fondo);
      border: 1px solid var(--etiqueta-fila-borde);
      border-radius: 999px;
      padding: 10px 14px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.04em;
      line-height: 1.3;
      color: var(--texto-oscuro);
      cursor: default;
    }

    /* Legibilidad: texto en frase; aspecto del mockup vía mayúsculas solo en pantallas anchas */
    @media (min-width: 600px) {
      .vet-label {
        text-transform: uppercase;
      }
    }

    .vet-input-wrap {
      border-radius: 14px;
      background: var(--verde-input);
      border: 1px solid rgba(45, 74, 66, 0.18);
      min-height: 48px;
      padding: 0 14px;
      display: flex;
      align-items: center;
      transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .vet-input-wrap:focus-within {
      border-color: var(--verde-azulado);
      box-shadow: 0 0 0 3px var(--focus-anillo);
    }

    .vet-input-wrap input {
      width: 100%;
      border: none;
      outline: none;
      background: transparent;
      color: var(--texto-oscuro);
      font-size: 15px;
      font-weight: 600;
    }

    .vet-input-wrap input::placeholder {
      color: #67877f;
      font-weight: 600;
    }

    /* Reutiliza .btn--signup (genbu-signup.css); bloque propio para apilar CTA + enlace secundario */
    .vet-actions {
      margin-top: 24px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 14px;
    }

    .vet-actions .btn--signup {
      width: min(100%, 280px);
      box-sizing: border-box;
    }

    a.logo-circle {
      text-decoration: none;
      color: inherit;
    }

    a.logo-circle:focus-visible {
      outline: 2px solid var(--verde-azulado);
      outline-offset: 4px;
      border-radius: 50%;
    }

    .vet-btn-submit {
      min-width: min(100%, 280px);
      min-height: 48px;
      padding: 12px 28px;
      border: 1px solid rgba(45, 74, 66, 0.18);
      border-radius: 14px;
      background: #b8dfd4;
      color: var(--texto-oscuro);
      font-family: "Nunito", sans-serif;
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(45, 74, 66, 0.08);
      transition: background 0.2s ease, transform 0.12s ease;
    }

    .vet-btn-submit:hover {
      background: #a8d4c8;
      transform: translateY(-1px);
    }

    .vet-btn-submit:focus-visible {
      outline: 2px solid var(--verde-azulado);
      outline-offset: 2px;
    }

    @media (max-width: 640px) {
      .header {
        flex-direction: column;
        text-align: center;
      }

      .vet-row {
        grid-template-columns: 1fr;
      }

      .vet-label {
        justify-content: flex-start;
        text-align: left;
        border-radius: 12px;
      }
    }

    .visually-hidden {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }
  </style>
</head>
<body>
  <div class="bg-pattern"></div>

  <main class="page page--vet">
    <header class="header">
      <a href="{{ route('login') }}" class="logo-circle" aria-label="Ir al inicio de sesión"></a>
        <img src="{{ asset('images/logo.png') }}" alt="">
      </a>
      <div class="headline">
        <h1>Perfil del médico veterinario</h1>
      </div>
    </header>

    <section class="card card--vet" aria-labelledby="vet-form-title">
      <h2 id="vet-form-title" class="visually-hidden">Datos profesionales del veterinario</h2>

      <form class="vet-form" id="vet-register-form" action="{{ route('veterinario.guardar') }}" method="post">
        @csrf
        <div class="vet-row">
          <label class="vet-label" for="tarjetaProfesional">N.º tarjeta profesional</label>
          <div class="vet-input-wrap">
            <input id="tarjetaProfesional" name="tarjetaProfesional" type="text" inputmode="numeric" autocomplete="off" placeholder="Ej. 12345" required>
          </div>
        </div>

        <div class="vet-row">
          <label class="vet-label" for="especializacion">Área de especialización</label>
          <div class="vet-input-wrap">
            <input id="especializacion" name="especializacion" type="text" autocomplete="organization-title" placeholder="Ej. Dermatología" required>
          </div>
        </div>

        <div class="vet-row">
          <label class="vet-label" for="cargo">Cargo en la clínica</label>
          <div class="vet-input-wrap">
            <input id="cargo" name="cargo" type="text" autocomplete="organization-title" placeholder="Ej. Médico tratante" required>
          </div>
        </div>

        <div class="vet-row">
          <label class="vet-label" for="consultorio">N.º de consultorio</label>
          <div class="vet-input-wrap">
            <input id="consultorio" name="consultorio" type="text" inputmode="numeric" autocomplete="off" placeholder="Ej. 3" required>
          </div>
        </div>

        <div class="vet-row">
          <label class="vet-label" for="horario">Horario de trabajo</label>
          <div class="vet-input-wrap">
            <input id="horario" name="horario" type="text" autocomplete="off" placeholder="Ej. Lun–Vie 8:00 – 18:00" required>
          </div>
        </div>

        <div class="vet-row">
          <label class="vet-label" for="estadoActual">Estado actual</label>
          <div class="vet-input-wrap">
            <input id="estadoActual" name="estadoActual" type="text" autocomplete="off" placeholder="Ej. Activo en planta" required>
          </div>
        </div>

        <div class="vet-row">
          <label class="vet-label" for="residencia">Lugar de residencia</label>
          <div class="vet-input-wrap">
            <input id="residencia" name="residencia" type="text" autocomplete="street-address" placeholder="Ciudad o dirección" required>
          </div>
        </div>

        <div class="vet-actions">
          <button type="submit" class="vet-btn-submit">Crear cuenta</button>
          <a class="btn--signup btn-secondary" href="{{ route('login') }}">Volver al inicio de sesión</a>
        </div>
      </form>
    </section>
  </main>

</body>
</html>