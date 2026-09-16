<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENBU - Panel del veterinario</title>
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
  body {
    font-family: 'Nunito', sans-serif;
    background: var(--verde-panel);
    min-height: 100vh;
    display: flex;
  }

  .sidebar {
    width: 220px;
    background: var(--verde-card);
    border-right: 1px solid var(--borde);
    display: flex;
    flex-direction: column;
    padding: 22px 16px;
    flex-shrink: 0;
    min-height: 100vh;
  }
  .sidebar-brand { display: flex; align-items: center; gap: 10px; padding: 0 6px 22px; }
  .logo-circle {
    width: 38px; height: 38px; border-radius: 50%;
    border: 2px solid var(--texto-oscuro); background: white;
    display: flex; align-items: center; justify-content: center; overflow: hidden;
  }
  .logo-circle img { width: 100%; height: 100%; object-fit: cover; }
  .brand-name { font-family: 'Bebas Neue', sans-serif; font-size: 19px; letter-spacing: 2px; color: var(--texto-oscuro); }

  .nav-list { list-style: none; display: flex; flex-direction: column; gap: 4px; margin-top: 6px; }
  .nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 12px; border-radius: 12px;
    color: var(--texto-suave); text-decoration: none;
    font-size: 14px; font-weight: 700;
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
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--verde-input); display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: var(--texto-oscuro); overflow: hidden;
  }
  .user-chip .name { font-size: 13px; font-weight: 700; color: var(--texto-oscuro); }
  .user-chip .role { font-size: 11px; color: var(--texto-suave); }

  .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
  .stat-card { background: var(--verde-card); border: 1px solid var(--borde); border-radius: 16px; padding: 18px 20px; }
  .stat-card .stat-num { font-family: 'Bebas Neue', sans-serif; font-size: 28px; color: var(--texto-oscuro); }
  .stat-card .stat-label { font-size: 11px; color: var(--texto-suave); font-weight: 700; letter-spacing: 0.4px; }

  .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; margin-bottom: 20px; }
  .panel { background: var(--verde-card); border: 1px solid var(--borde); border-radius: 18px; padding: 20px 22px; }
  .panel-title { font-size: 14px; font-weight: 700; color: var(--texto-oscuro); margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
  .panel-title a { font-size: 12px; color: var(--verde-boton); text-decoration: none; font-weight: 700; }

  .thumb-strip { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 4px; }
  .thumb-card { flex-shrink: 0; width: 140px; }
  .thumb-img {
    width: 140px; height: 100px; border-radius: 12px;
    background: linear-gradient(135deg, var(--verde-input), var(--verde-fondo));
    display: flex; align-items: center; justify-content: center;
  }
  .thumb-img svg { width: 30px; height: 30px; stroke: var(--texto-oscuro); opacity: 0.55; }
  .thumb-name { font-size: 12px; font-weight: 700; color: var(--texto-oscuro); margin-top: 6px; }
  .thumb-meta { font-size: 11px; color: var(--texto-suave); }

  .donut-wrap { display: flex; flex-direction: column; align-items: center; padding-top: 4px; }
  .donut-svg { width: 140px; height: 140px; }
  .donut-label { font-size: 11px; color: var(--texto-suave); text-align: center; margin-top: 8px; }

  .history-table { width: 100%; border-collapse: collapse; }
  .history-table th { text-align: left; font-size: 11px; color: var(--texto-suave); font-weight: 700; letter-spacing: 0.4px; padding: 8px 10px; border-bottom: 1px solid var(--borde); }
  .history-table td { padding: 10px; font-size: 13px; color: var(--texto-oscuro); border-bottom: 1px solid var(--borde); }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
  .badge-ok { background: #dcefe6; color: #2f7a5a; }
  .badge-pending { background: #fbe8d9; color: #b5651d; }

  @media (max-width: 900px) {
    .content-grid { grid-template-columns: 1fr; }
    .stats-row { grid-template-columns: 1fr 1fr; }
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
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
        Mis mascotas
      </a></li>
      <li><a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        Diagnóstico IA
      </a></li>
      <li><a href="#" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-6"/></svg>
        Historial
      </a></li>
      <li><a href="{{ route('veterinario.form') }}" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></svg>
        Mi perfil
      </a></li>
    </ul>

    <div class="sidebar-cta">
      <a href="{{ route('viewpet') }}" class="btn-new-case">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        Nuevo caso
      </a>
      <a href="{{ route('login') }}" class="logout-link">Cerrar sesión</a>
    </div>
  </aside>

  <main class="main">
    <div class="topbar">
      <div>
        <h1>Bienvenido, {{ $nombre ?? 'Dr(a). Nombre' }}</h1>
        <p>Este es el resumen de tu actividad en GENBU.</p>
      </div>
      <div class="user-chip">
        <div class="avatar">{{ isset($nombre) ? strtoupper(substr($nombre, 0, 1)) : 'V' }}</div>
        <div>
          <div class="name">{{ $nombre ?? 'Dr(a). Nombre' }}</div>
          <div class="role">Veterinario</div>
        </div>
      </div>
    </div>

    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-num">{{ $totalMascotas ?? '0' }}</div>
        <div class="stat-label">MASCOTAS A CARGO</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">{{ $diagnosticosPendientes ?? '0' }}</div>
        <div class="stat-label">DIAGNÓSTICOS SIN CONFIRMAR</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">{{ $reportesGenerados ?? '0' }}</div>
        <div class="stat-label">REPORTES GENERADOS</div>
      </div>
    </div>

    <div class="content-grid">
      <div class="panel">
        <div class="panel-title"><span>Imágenes recientes analizadas</span><a href="#">Ver todas</a></div>
        <div class="thumb-strip">
          @forelse (($imagenesRecientes ?? []) as $img)
            <div class="thumb-card">
              <div class="thumb-img">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.6"><rect x="3" y="4" width="18" height="14" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="M21 15l-5-5L5 18"/></svg>
              </div>
              <div class="thumb-name">{{ $img['mascota'] }}</div>
              <div class="thumb-meta">{{ $img['fecha'] }}</div>
            </div>
          @empty
            @foreach (['Mia', 'Rocco', 'Luna'] as $ejemplo)
              <div class="thumb-card">
                <div class="thumb-img">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="1.6"><rect x="3" y="4" width="18" height="14" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="M21 15l-5-5L5 18"/></svg>
                </div>
                <div class="thumb-name">{{ $ejemplo }}</div>
                <div class="thumb-meta">Sin datos aún</div>
              </div>
            @endforeach
          @endforelse
        </div>
      </div>

      <div class="panel">
        <div class="panel-title"><span>Confianza promedio IA</span></div>
        <div class="donut-wrap">
          @php $confianza = $confianzaPromedio ?? 0; @endphp
          <svg class="donut-svg" viewBox="0 0 120 120">
            <circle cx="60" cy="60" r="50" fill="none" stroke="#d4ddd8" stroke-width="14"/>
            <circle cx="60" cy="60" r="50" fill="none" stroke="#4a8a7a" stroke-width="14"
              stroke-dasharray="{{ round(2 * 3.1416 * 50 * $confianza / 100, 1) }} 999"
              stroke-linecap="round" transform="rotate(-90 60 60)"/>
            <text x="60" y="66" text-anchor="middle" font-family="Bebas Neue" font-size="24" fill="#2d4a42">{{ $confianza }}%</text>
          </svg>
          <div class="donut-label">Promedio de confianza de los últimos diagnósticos confirmados</div>
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-title"><span>Historial reciente</span><a href="#">Ver historial completo</a></div>
      <table class="history-table">
        <thead>
          <tr><th>Mascota</th><th>Fecha</th><th>Resultado</th><th>Confianza</th><th>Estado</th></tr>
        </thead>
        <tbody>
          @forelse (($diagnosticosRecientes ?? []) as $d)
            <tr>
              <td>{{ $d['mascota'] }}</td>
              <td>{{ $d['fecha'] }}</td>
              <td>{{ $d['resultado'] }}</td>
              <td>{{ $d['confianza'] }}%</td>
              <td><span class="badge {{ $d['confirmado'] ? 'badge-ok' : 'badge-pending' }}">{{ $d['confirmado'] ? 'Confirmado' : 'Pendiente' }}</span></td>
            </tr>
          @empty
            <tr><td colspan="5" style="text-align:center; color: var(--texto-suave); padding: 22px 0;">Aún no hay diagnósticos registrados.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>
