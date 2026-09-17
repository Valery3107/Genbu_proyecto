<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENBU - Panel de secretaría</title>
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
  .nav-item.active { background: var(--verde-boton); color: white; }

  .sidebar-cta { margin-top: auto; display: flex; flex-direction: column; gap: 10px; }
  .btn-new-case {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    background: var(--verde-boton); color: white; text-decoration: none;
    padding: 11px; border-radius: 12px; font-size: 13px; font-weight: 700; letter-spacing: 0.4px;
  }
  .btn-new-case:hover { background: var(--verde-boton-hover); }
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

  .stats-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px; }
  .stat-card { background: var(--verde-card); border: 1px solid var(--borde); border-radius: 16px; padding: 18px 20px; }
  .stat-card .stat-num { font-family: 'Bebas Neue', sans-serif; font-size: 28px; color: var(--texto-oscuro); }
  .stat-card .stat-label { font-size: 11px; color: var(--texto-suave); font-weight: 700; letter-spacing: 0.4px; }

  .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; margin-bottom: 20px; }
  .panel { background: var(--verde-card); border: 1px solid var(--borde); border-radius: 18px; padding: 20px 22px; }
  .panel-title { font-size: 14px; font-weight: 700; color: var(--texto-oscuro); margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
  .panel-title a { font-size: 12px; color: var(--verde-boton); text-decoration: none; font-weight: 700; }

  .history-table { width: 100%; border-collapse: collapse; }
  .history-table th { text-align: left; font-size: 11px; color: var(--texto-suave); font-weight: 700; letter-spacing: 0.4px; padding: 8px 10px; border-bottom: 1px solid var(--borde); }
  .history-table td { padding: 10px; font-size: 13px; color: var(--texto-oscuro); border-bottom: 1px solid var(--borde); }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
  .badge-ok { background: #dcefe6; color: #2f7a5a; }

  .vet-list { display: flex; flex-direction: column; gap: 12px; }
  .vet-row { display: flex; align-items: center; gap: 10px; }
  .vet-avatar {
    width: 34px; height: 34px; border-radius: 50%; background: var(--verde-input);
    display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: var(--texto-oscuro);
    flex-shrink: 0;
  }
  .vet-info .vet-name { font-size: 13px; font-weight: 700; color: var(--texto-oscuro); }
  .vet-info .vet-especialidad { font-size: 11px; color: var(--texto-suave); }

  @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }
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
      <li><a href="{{ route('viewpet') }}" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Registrar mascota
      </a></li>
      <li><a href="{{ route('mascotas.index') }}" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
        Mascotas registradas
      </a></li>
      <li><a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="9" cy="8" r="3.5"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M17 8a3 3 0 1 1-3-3"/><path d="M21 20c0-2.5-1.6-4.6-4-5.4"/></svg>
        Veterinarios
      </a></li>
      <li><a href="{{ route('perfil.crear') }}" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></svg>
        Mi perfil
      </a></li>
    </ul>

    <div class="sidebar-cta">
      <a href="{{ route('viewpet') }}" class="btn-new-case">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Nueva mascota
      </a>
      <form method="post" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="logout-link" style="background:none; border:none; cursor:pointer; padding:0; font:inherit;">Cerrar sesión</button>
      </form>
    </div>
  </aside>

  <main class="main">
    <div class="topbar">
      <div>
        <h1>Bienvenida, {{ $nombre ?? 'Nombre' }}</h1>
        <p>Panel de gestión administrativa de GENBU.</p>
      </div>
      <div class="user-chip">
        <div class="avatar">{{ isset($nombre) ? strtoupper(substr($nombre, 0, 1)) : 'S' }}</div>
        <div>
          <div class="name">{{ $nombre ?? 'Nombre' }}</div>
          <div class="role">Secretaria / Auxiliar</div>
        </div>
      </div>
    </div>

    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-num">{{ $totalMascotas ?? '0' }}</div>
        <div class="stat-label">MASCOTAS REGISTRADAS</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">{{ $registrosHoy ?? '0' }}</div>
        <div class="stat-label">REGISTROS DE HOY</div>
      </div>
    </div>

    <div class="content-grid">
      <div class="panel">
        <div class="panel-title"><span>Últimos registros</span><a href="#">Ver todos</a></div>
        <table class="history-table">
          <thead><tr><th>Mascota</th><th>Tutor</th><th>Fecha registro</th><th>Estado</th></tr></thead>
          <tbody>
            @forelse (($registrosRecientes ?? []) as $r)
              <tr>
                <td>{{ $r['mascota'] }}</td>
                <td>{{ $r['tutor'] }}</td>
                <td>{{ $r['fecha'] }}</td>
                <td><span class="badge badge-ok">Registrado</span></td>
              </tr>
            @empty
              <tr><td colspan="4" style="text-align:center; color: var(--texto-suave); padding: 22px 0;">Aún no hay mascotas registradas hoy.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="panel">
        <div class="panel-title"><span>Veterinarios disponibles</span></div>
        <div class="vet-list">
          @forelse (($veterinarios ?? []) as $v)
            <div class="vet-row">
              <div class="vet-avatar">{{ strtoupper(substr($v['nombre'], 0, 1)) }}</div>
              <div class="vet-info">
                <div class="vet-name">{{ $v['nombre'] }}</div>
                <div class="vet-especialidad">{{ $v['especialidad'] }}</div>
              </div>
            </div>
          @empty
            <div style="color: var(--texto-suave); font-size: 13px;">Aún no hay veterinarios registrados.</div>
          @endforelse
        </div>
      </div>
    </div>
  </main>

</body>
</html>