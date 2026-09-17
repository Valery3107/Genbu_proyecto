<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENBU - Mascotas registradas</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --verde-fondo: #a8c8c0;
    --verde-boton: #4a8a7a;
    --verde-boton-hover: #3a7060;
    --verde-card: #ffffff;
    --verde-panel: #eef4f1;
    --verde-input: #d4ddd8;
    --texto-oscuro: #2d4a42;
    --texto-suave: #6a8a82;
    --borde: rgba(45, 74, 66, 0.10);
    --rojo-suave: #c96b5a;
    --rojo-fondo: #f6dede;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Nunito', sans-serif; background: var(--verde-panel); min-height: 100vh; display: flex; }

  .sidebar {
    width: 220px; background: var(--verde-card); border-right: 1px solid var(--borde);
    display: flex; flex-direction: column; padding: 22px 16px; flex-shrink: 0; min-height: 100vh;
  }
  .sidebar-brand { display: flex; align-items: center; gap: 10px; padding: 0 6px 22px; }
  .logo-circle {
    width: 38px; height: 38px; border-radius: 50%; border: 2px solid var(--texto-oscuro);
    background: white; display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .logo-circle img { width: 100%; height: 100%; object-fit: cover; }
  .brand-name { font-family: 'Bebas Neue', sans-serif; font-size: 19px; letter-spacing: 2px; color: var(--texto-oscuro); }

  .nav-list { list-style: none; display: flex; flex-direction: column; gap: 4px; margin-top: 6px; }
  .nav-item {
    display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px;
    color: var(--texto-suave); text-decoration: none; font-size: 14px; font-weight: 700;
    transition: background 0.15s ease, color 0.15s ease;
  }
  .nav-item svg { width: 19px; height: 19px; stroke: currentColor; flex-shrink: 0; }
  .nav-item:hover { background: var(--verde-panel); color: var(--texto-oscuro); }
  .nav-item.active { background: var(--verde-boton); color: white; }

  .sidebar-cta { margin-top: auto; display: flex; flex-direction: column; gap: 10px; }
  .btn-new-case {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--verde-boton); color: white; text-decoration: none;
    padding: 11px; border-radius: 12px; font-size: 13px; font-weight: 700; letter-spacing: 0.4px;
    border: none; cursor: pointer; width: 100%; font-family: 'Nunito', sans-serif;
  }
  .btn-new-case:hover { background: var(--verde-boton-hover); }
  .logout-link {
    text-align: center; color: var(--texto-suave); font-size: 12px; font-weight: 700;
    text-decoration: none; background: none; border: none; cursor: pointer; width: 100%; font-family: 'Nunito', sans-serif;
  }
  .logout-link:hover { color: var(--texto-oscuro); }

  .main { flex: 1; padding: 26px 34px 50px; min-width: 0; }
  .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; flex-wrap: wrap; gap: 12px; }
  .topbar h1 { font-family: 'Bebas Neue', sans-serif; font-size: 26px; letter-spacing: 1.5px; color: var(--texto-oscuro); }
  .topbar p { color: var(--texto-suave); font-size: 13px; margin-top: 2px; }

  .exito-msg {
    background: #dcefe6; color: #2f7a5a; padding: 12px 16px; border-radius: 12px;
    font-size: 13px; font-weight: 700; margin-bottom: 18px;
  }

  .panel { background: var(--verde-card); border: 1px solid var(--borde); border-radius: 18px; padding: 20px 22px; }

  .history-table { width: 100%; border-collapse: collapse; }
  .history-table th { text-align: left; font-size: 11px; color: var(--texto-suave); font-weight: 700; letter-spacing: 0.4px; padding: 8px 10px; border-bottom: 1px solid var(--borde); }
  .history-table td { padding: 10px; font-size: 13px; color: var(--texto-oscuro); border-bottom: 1px solid var(--borde); vertical-align: middle; }

  .accion-btn {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px;
    text-decoration: none; border: none; cursor: pointer; font-family: 'Nunito', sans-serif;
  }
  .accion-editar { background: var(--verde-input); color: var(--texto-oscuro); }
  .accion-editar:hover { background: #c3d0ca; }
  .accion-eliminar { background: var(--rojo-fondo); color: var(--rojo-suave); }
  .accion-eliminar:hover { background: #f0caca; }

  @media (max-width: 640px) {
    body { flex-direction: column; }
    .sidebar { width: 100%; min-height: auto; flex-direction: row; overflow-x: auto; }
    .nav-list { flex-direction: row; }
    .sidebar-cta { display: none; }
    .history-table { display: block; overflow-x: auto; }
  }
</style>
</head>
<body>

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-circle"><img src="{{ asset('images/logo.png') }}" alt="Logo GENBU"></div>
      <span class="brand-name">GENBU</span>
    </div>

    <ul class="nav-list">
      <li>
        @php
          $rol = session('usuario_rol');
          $rutaDashboard = match($rol) {
            'veterinario' => route('dashboard.veterinario'),
            'secretaria' => route('dashboard.secretaria'),
            'administrador' => route('dashboard.administrador'),
            default => route('login'),
          };
        @endphp
        <a href="{{ $rutaDashboard }}" class="nav-item">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="2"/><rect x="14" y="3" width="7" height="5" rx="2"/><rect x="14" y="12" width="7" height="9" rx="2"/><rect x="3" y="16" width="7" height="5" rx="2"/></svg>
          Dashboard
        </a>
      </li>
      <li><a href="{{ route('mascotas.index') }}" class="nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
        Mascotas
      </a></li>
    </ul>

    <div class="sidebar-cta">
      <a href="{{ route('viewpet') }}" class="btn-new-case">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Nueva mascota
      </a>
      <form method="post" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="logout-link">Cerrar sesión</button>
      </form>
    </div>
  </aside>

  <main class="main">
    <div class="topbar">
      <div>
        <h1>Mascotas registradas</h1>
        <p>Consulta, edita o elimina el perfil de un paciente.</p>
      </div>
    </div>

    @if (session('exito'))
      <div class="exito-msg">{{ session('exito') }}</div>
    @endif

    <div class="panel">
      <table class="history-table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Raza</th>
            <th>Sexo</th>
            <th>Tutor</th>
            <th>Teléfono</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($mascotas as $mascota)
            <tr>
              <td>{{ $mascota->nombre }}</td>
              <td>{{ $mascota->raza }}</td>
              <td>{{ $mascota->sexo }}</td>
              <td>{{ $mascota->tutor }}</td>
              <td>{{ $mascota->telefono_tutor ?? '—' }}</td>
              <td>
                <div style="display:flex; gap:6px;">
                  <a href="{{ route('mascotas.editar', $mascota->id_mascota) }}" class="accion-btn accion-editar">Editar</a>
                  <form method="post" action="{{ route('mascotas.eliminar', $mascota->id_mascota) }}" style="margin:0;" onsubmit="return confirm('¿Seguro que quieres eliminar a {{ $mascota->nombre }}? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="accion-btn accion-eliminar">Eliminar</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="text-align:center; color: var(--texto-suave); padding: 26px 0;">
                Aún no hay mascotas registradas. <a href="{{ route('viewpet') }}" style="color: var(--verde-boton); font-weight:700;">Registra la primera</a>.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>