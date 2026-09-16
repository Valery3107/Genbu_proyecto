<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENBU - Panel de administración</title>
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
  .nav-item.active { background: var(--texto-oscuro); color: white; }

  .sidebar-cta { margin-top: auto; display: flex; flex-direction: column; gap: 10px; }
  .btn-new-case {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--texto-oscuro); color: white; text-decoration: none;
    padding: 11px; border-radius: 12px; font-size: 13px; font-weight: 700; letter-spacing: 0.4px;
  }
  .btn-new-case:hover { background: #1f352f; }
  .logout-link { text-align: center; color: var(--texto-suave); font-size: 12px; font-weight: 700; text-decoration: none; }
  .logout-link:hover { color: var(--texto-oscuro); }

  .main { flex: 1; padding: 26px 34px 50px; min-width: 0; }
  .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 26px; }
  .topbar h1 { font-family: 'Bebas Neue', sans-serif; font-size: 26px; letter-spacing: 1.5px; color: var(--texto-oscuro); }
  .topbar p { color: var(--texto-suave); font-size: 13px; margin-top: 2px; }
  .user-chip { display: flex; align-items: center; gap: 10px; }
  .user-chip .avatar {
    width: 36px; height: 36px; border-radius: 50%; background: var(--verde-input);
    display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700;
    color: var(--texto-oscuro); overflow: hidden;
  }
  .user-chip .name { font-size: 13px; font-weight: 700; color: var(--texto-oscuro); }
  .user-chip .role { font-size: 11px; color: var(--texto-suave); }

  .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
  .stat-card { background: var(--verde-card); border: 1px solid var(--borde); border-radius: 16px; padding: 18px 20px; }
  .stat-card .stat-num { font-family: 'Bebas Neue', sans-serif; font-size: 26px; color: var(--texto-oscuro); }
  .stat-card .stat-label { font-size: 10.5px; color: var(--texto-suave); font-weight: 700; letter-spacing: 0.4px; }

  .content-grid { display: grid; grid-template-columns: 1.3fr 1fr; gap: 18px; margin-bottom: 20px; }
  .panel { background: var(--verde-card); border: 1px solid var(--borde); border-radius: 18px; padding: 20px 22px; }
  .panel-title { font-size: 14px; font-weight: 700; color: var(--texto-oscuro); margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
  .panel-title a { font-size: 12px; color: var(--verde-boton); text-decoration: none; font-weight: 700; }

  .history-table { width: 100%; border-collapse: collapse; }
  .history-table th { text-align: left; font-size: 11px; color: var(--texto-suave); font-weight: 700; letter-spacing: 0.4px; padding: 8px 10px; border-bottom: 1px solid var(--borde); }
  .history-table td { padding: 10px; font-size: 13px; color: var(--texto-oscuro); border-bottom: 1px solid var(--borde); }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
  .badge-ok { background: #dcefe6; color: #2f7a5a; }
  .badge-off { background: #f6dede; color: #b5453a; }

  .code-list { display: flex; flex-direction: column; gap: 10px; }
  .code-row {
    display: flex; align-items: center; justify-content: space-between;
    background: var(--verde-panel); border-radius: 10px; padding: 9px 12px;
  }
  .code-value { font-family: 'Bebas Neue', sans-serif; letter-spacing: 1px; font-size: 14px; color: var(--texto-oscuro); }
  .code-role { font-size: 10.5px; color: var(--texto-suave); font-weight: 700; }

  @media (max-width: 900px) {
    .content-grid { grid-template-columns: 1fr; }
    .stats-row { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 640px) {
    body { flex-direction: column; }
    .sidebar { width: 100%; min-height: auto; flex-direction: row; overflow-x: auto; }
    .nav-list { flex-direction: row; }
    .sidebar-cta { display: none; }
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
      <li><a href="#" class="nav-item active">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="2"/><rect x="14" y="3" width="7" height="5" rx="2"/><rect x="14" y="12" width="7" height="9" rx="2"/><rect x="3" y="16" width="7" height="5" rx="2"/></svg>
        Dashboard
      </a></li>
      <li><a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="9" cy="8" r="3.5"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M17 8a3 3 0 1 1-3-3"/><path d="M21 20c0-2.5-1.6-4.6-4-5.4"/></svg>
        Usuarios
      </a></li>
      <li><a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>
        Códigos de acceso
      </a></li>
      <li><a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 12h4l3 8 4-16 3 8h4"/></svg>
        Auditoría
      </a></li>
      <li><a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M4 19V5a2 2 0 0 1 2-2h8l6 6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z"/><path d="M14 3v6h6"/></svg>
        Reportes
      </a></li>
    </ul>

    <div class="sidebar-cta">
      <a href="#" class="btn-new-case">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Generar código
      </a>
      <a href="{{ route('login') }}" class="logout-link">Cerrar sesión</a>
    </div>
  </aside>

  <main class="main">
    <div class="topbar">
      <div>
        <h1>Panel de administración</h1>
        <p>Gestión general del sistema GENBU.</p>
      </div>
      <div class="user-chip">
        <div class="avatar">{{ isset($nombre) ? strtoupper(substr($nombre, 0, 1)) : 'A' }}</div>
        <div>
          <div class="name">{{ $nombre ?? 'Nombre' }}</div>
          <div class="role">Administrador</div>
        </div>
      </div>
    </div>

    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-num">{{ $totalUsuarios ?? '0' }}</div>
        <div class="stat-label">USUARIOS ACTIVOS</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">{{ $totalVeterinarios ?? '0' }}</div>
        <div class="stat-label">VETERINARIOS</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">{{ $codigosDisponibles ?? '0' }}</div>
        <div class="stat-label">CÓDIGOS SIN USAR</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">{{ $totalMascotas ?? '0' }}</div>
        <div class="stat-label">MASCOTAS REGISTRADAS</div>
      </div>
    </div>

    <div class="content-grid">
      <div class="panel">
        <div class="panel-title"><span>Usuarios recientes</span><a href="#">Ver todos</a></div>
        <table class="history-table">
          <thead><tr><th>Nombre</th><th>Rol</th><th>Fecha registro</th><th>Estado</th></tr></thead>
          <tbody>
            @forelse (($usuariosRecientes ?? []) as $u)
              <tr>
                <td>{{ $u['nombre'] }}</td>
                <td>{{ $u['rol'] }}</td>
                <td>{{ $u['fecha'] }}</td>
                <td><span class="badge {{ $u['activo'] ? 'badge-ok' : 'badge-off' }}">{{ $u['activo'] ? 'Activo' : 'Inactivo' }}</span></td>
              </tr>
            @empty
              <tr><td colspan="4" style="text-align:center; color: var(--texto-suave); padding: 22px 0;">Aún no hay usuarios registrados.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="panel">
        <div class="panel-title"><span>Códigos de acceso activos</span></div>
        <div class="code-list">
          @forelse (($codigosActivos ?? []) as $c)
            <div class="code-row">
              <span class="code-value">{{ $c['codigo'] }}</span>
              <span class="code-role">{{ $c['rol'] }}</span>
            </div>
          @empty
            <div style="color: var(--texto-suave); font-size: 13px;">No hay códigos sin usar todavía.</div>
          @endforelse
        </div>
      </div>
    </div>
  </main>

</body>
</html>