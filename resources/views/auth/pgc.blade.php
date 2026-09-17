<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GENBU - Login</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --verde-fondo: #a8c8c0;
    --verde-boton: #4a8a7a;
    --verde-boton-hover: #3a7060;
    --verde-card: #e8ede8;
    --verde-input: #d4ddd8;
    --texto-oscuro: #2d4a42;
    --texto-link: #4a8a7a;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Nunito', sans-serif;
    background-color: var(--verde-fondo);
    min-height: 100vh;
    overflow: hidden;
    position: relative;
  }
  .bg-pattern {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    z-index: 0;
    opacity: 0.15;
    background-image: url("{{ asset('images/estampado.png') }}");
    background-repeat: repeat;
    background-size: 200px 200px;
}
 
  .main-container {
    position: relative;
    z-index: 1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  .header-slogan {
    padding: 18px 30px 10px;
    display: flex;
    align-items: center;
    gap: 20px;
  }
  .logo-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 3px solid var(--texto-oscuro);
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 11px;
    font-weight: 800;
    color: var(--texto-oscuro);
    letter-spacing: 2px;
  }
  .logo-paw { font-size: 36px; line-height: 1; }
  .slogan {
    font-size: clamp(22px, 3.5vw, 36px);
    font-weight: 400;
    color: var(--texto-oscuro);
  }
  .slogan strong {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(28px, 4.5vw, 46px);
    letter-spacing: 3px;
  }
  .content-row {
    flex: 1;
    display: flex;
    align-items: stretch;
    padding: 0;
    gap: 0;
    margin-top: -20px;
}
  .dogs-section {
    flex: 0 0 58%;
    position: relative;
    overflow: hidden;
   
}
  .dogs-bg-folder {
    width: 100%;
    height: 100%;
    min-height: 500px;
    position: relative;
    border-radius: 0 30px 0 0;
    overflow: hidden;
    
}
  .dogs-emoji {
    font-size: 100px;
    padding-bottom: 10px;
    letter-spacing: -10px;
  }
 
  .dogs-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: 10% center;
    position: absolute;
    top: 0; left: 0;
}
  .flowers {
    position: absolute;
    top: 10px; right: 20px;
    font-size: 28px;
    opacity: 0.7;
  }
  .login-section {
    flex: 0 0 42%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 30px;
}
  .login-card {
    background: var(--verde-card);
    border-radius: 24px;
    padding: 40px 35px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    width: 100%;
    max-width: 380px;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
  }
  .user-icon-top {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 3px dashed var(--texto-oscuro);
    background: #e8ede8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
  }
  .login-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 38px;
    letter-spacing: 5px;
    color: var(--texto-oscuro);
    margin-top: 25px;
    margin-bottom: 25px;
  }
  .input-group-custom {
    width: 100%;
    display: flex;
    align-items: center;
    background: var(--verde-input);
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 14px;
    gap: 10px;
  }
  .input-icon { font-size: 18px; opacity: 0.6; }
  .input-group-custom input {
    border: none;
    background: transparent;
    outline: none;
    width: 100%;
    font-family: 'Nunito', sans-serif;
    font-size: 13px;
    letter-spacing: 2px;
    color: var(--texto-oscuro);
    font-weight: 600;
  }
  .input-group-custom input::placeholder {
    color: #6a8a82;
    letter-spacing: 2px;
    font-weight: 600;
  }
  .btn-primary-genbu {
    width: 100%;
    background: var(--verde-boton);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 13px;
    font-family: 'Bebas Neue', sans-serif;
    font-size: 18px;
    letter-spacing: 4px;
    margin-top: 8px;
    margin-bottom: 20px;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
  }
  .btn-primary-genbu:hover { background: var(--verde-boton-hover); transform: translateY(-1px); }
  .link-text {
    font-size: 13px;
    color: var(--texto-link);
    text-decoration: none;
    display: block;
    text-align: center;
    margin-bottom: 8px;
    font-weight: 600;
  }
  .link-text:hover { opacity: 0.7; text-decoration: underline; }
</style>
</head>
<body>
    
<div class="bg-pattern"></div>

<div class="main-container">

  <!-- BLOQUE 1: Header con logo y slogan -->
  <div class="header-slogan">
    <div class="logo-circle">
    <img src="{{ asset('images/logo.png') }}" style="width:80px; height:80px; border-radius:50%; object-fit:cover;">
</div>
    <div class="slogan">
      Cuidar su <strong>PIEL</strong> es cuidar su <strong>BIENESTAR</strong>
    </div>
  </div>

  <!-- BLOQUE 2: Perritos + Card login -->
  <div class="content-row">

    <!-- Imagen perritos -->
    <div class="dogs-section">
      <div class="dogs-bg-folder">
        <div class="flowers">🌼🌸🌼</div>
        <img src="{{ asset('images/fondo.png') }}" class="dogs-img">
        
      </div>
    </div>

    <!-- Card login -->
    <div class="login-section">
      <div class="login-card">
        <div class="user-icon-top">
            <img src="{{ asset('images/login.png') }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
        </div>
        @if ($errors->any())
          <div style="width:100%; background:#f6dede; color:#b5453a; padding:10px 14px; border-radius:10px; margin-bottom:14px; font-size:13px; font-weight:600; text-align:center;">
            {{ $errors->first() }}
          </div>
        @endif
        <div class="login-title">LOGIN</div>
        <form method="post" action="{{ route('login.autenticar') }}" style="width:100%;">
          @csrf
          <div class="input-group-custom">
            <span class="input-icon">
              <img src="{{ asset('images/bichito.png') }}" style="width:20px; height:20px; object-fit:contain;">
            </span>
            <input type="email" name="correo" placeholder="CORREO" value="{{ old('correo') }}" required>
          </div>
          <div class="input-group-custom">
            <span class="input-icon">
              <img src="{{ asset('images/candado.png') }}" style="width:20px; height:20px; object-fit:cover;">
            </span>
            <input type="password" name="contrasena" placeholder="CONTRASEÑA" required>
          </div>
          <button type="submit" class="btn-primary-genbu">INICIAR SESIÓN</button>
        </form>
        <a href="{{ route('password.solicitar') }}" class="link-text">¿Olvidaste tu contraseña?</a>
        <a href="{{ route('signup') }}" class="link-text">Crear una cuenta nueva</a>
      </div>
    </div>

  </div>
</div>



</body>
</html>