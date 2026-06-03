<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos - Parently</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../style/navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #F5E6D3 !important;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #FFBDC8 !important;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-nav .nav-link {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff !important;
            transition: 0.3s;
            padding: 8px 15px;
            border-radius: 20px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #ffffff;
            color: #D94571 !important;
        }

        

        /* ===== HEADER RECURSOS ===== */
        .recursos-header {
            background: linear-gradient(135deg, #ffb3d9 0%, #ff9ac5 100%);
            padding: 40px;
            text-align: center;
            color: white;
            
        }

        .recursos-header h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* ===== PORTAL SECTION ===== */
        .portal-section {
            display: flex;
            gap: 40px;
            align-items: center;
            padding: 60px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .portal-image {
            flex: 1;
            text-align: center;
        }

        .portal-image img {
            width: 100%;
            max-width: 400px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .portal-content {
            flex: 1;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .portal-content h2 {
            color: #D94571;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .portal-content p {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
            margin-bottom: 15px;
            text-align: justify;
        }

        .portal-content strong {
            color: #000;
            font-weight: bold;
        }

        .portal-content em {
            font-style: italic;
            color: #666;
        }

        /* ===== SECTION TITLE ===== */
        .section-title {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #D94571;
            margin: 60px 0 40px;
            padding: 0 20px;
        }

        /* ===== LO MÁS VISTO ===== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-item {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(217, 69, 113, 0.2);
        }

        .card-item-img {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #ffb3d9, #ff9ac5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
        }

        .card-item-body {
            padding: 25px;
        }

        .card-item-body h3 {
            color: #D94571;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .card-item-body p {
            font-size: 15px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .card-item-link {
            color: #D94571;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
        }

        .card-item-link:hover {
            color: #ff4081;
            text-decoration: underline;
        }

        /* ===== CONSEJOS GRID ===== */
        .consejos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .consejo-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .consejo-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(217, 69, 113, 0.2);
        }

        .consejo-img {
            width: 100%;
            height: 180px;
            background: linear-gradient(135deg, #ffe0b2, #ffcc80);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
        }

        .consejo-body {
            padding: 20px;
        }

        .consejo-body h4 {
            color: #D94571;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .consejo-body p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        /* ===== ETAPAS BUTTONS ===== */
        .etapas-section {
            text-align: center;
            padding: 40px;
            background: rgba(255, 179, 217, 0.1);
            border-radius: 20px;
            margin: 40px auto;
            max-width: 1200px;
        }

        .etapas-section h3 {
            color: #D94571;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .etapas-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .etapa-btn {
            padding: 20px 30px;
            background: linear-gradient(135deg, #ff6fa5, #ff4081);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .etapa-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(255, 64, 129, 0.3);
        }

        .etapa-icon {
            font-size: 40px;
        }

        /* ===== GUÍAS SECTION ===== */
        .guias-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .guia-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }

        .guia-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(217, 69, 113, 0.2);
            border-color: #D94571;
        }

        .guia-img {
            width: 100%;
            height: 150px;
            background: linear-gradient(135deg, #f48fb1, #ec407a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
        }

        .guia-body {
            padding: 20px;
        }

        .guia-body h5 {
            color: #D94571;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .guia-body p {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: linear-gradient(135deg, #ff6fa5, #ff4081);
            color: white;
            padding: 40px;
            text-align: center;
            margin-top: 60px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .footer-logo img {
            width: 50px;
            height: auto;
        }

        .footer-logo h2 {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .portal-section {
                flex-direction: column;
                padding: 30px 20px;
            }

            .recursos-header h1 {
                font-size: 32px;
            }

            .section-title {
                font-size: 28px;
                margin: 40px 0 30px;
            }

            .cards-grid, .consejos-grid, .guias-grid {
                grid-template-columns: 1fr;
                padding: 20px;
                gap: 20px;
            }

            .etapas-buttons {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">

    <!-- Logo + nombre (izquierda) -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">
      Parently
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Opciones (derecha) -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav mx-auto gap-2">
        <li class="nav-item">
          <a class="nav-link" href="recursos.php">Recursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="actividades.php">Actividades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="especialistas.php">Especialistas</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="comunidades.php">Comunidades</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="contactanos.php">Contactanos</a>
        </li>
      </ul>
      
      <!-- Botones - Con sesión o sin sesión -->
      <div class="d-flex gap-2 align-items-center">
        <?php if (isset($_SESSION["usuario_nombre"])): ?>
          <!-- Usuario logueado -->
          <div class="profile-btn d-flex align-items-center gap-2">
            <a href="perfil.php" class="avatar-link">
              <div class="avatar-small">
                <?php echo strtoupper(substr($_SESSION["usuario_nombre"], 0, 1)); ?>
              </div>
            </a>
            <a href="perfil.php" class="profile-name"><?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></a>
            <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
          </div>
        <?php else: ?>
          <!-- Usuario sin sesión -->
          <a href="login.php" class="btn btn-outline-success">Iniciar Sesión</a>
          <a href="registro.php" class="btn btn-success">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>

  </div>
</nav>

<!-- HEADER -->
<div class="recursos-header">
  <h1>🎓 RECURSOS</h1>
  <p style="font-size: 18px; margin: 0;">Portal de la Crianza</p>
</div>

<!-- PORTAL SECTION -->
<div class="portal-section">
  <div class="portal-image">
    <img src="../photos/familia.jpg" alt="Familia feliz">
  </div>
  <div class="portal-content">
    <h2>Portal de la Crianza</h2>
    <p>
      <strong>Ayudando a madres, padres y cuidadores a darles a niñas, niños y adolescentes el mejor comienzo en la vida.</strong>
    </p>
    <p>
      Todos queremos lo mejor para nuestros hijos e hijas, pero no siempre es tarea fácil.
    </p>
    <p>
      <strong>Por qué PARENTLY ofrece ideas, consejos de expertos e información confiable</strong>
      para acompañar a las familias en cada etapa del crecimiento de niñas, niños y adolescentes.
    </p>
    <p>
      <strong>Encontrá contenidos, recursos y herramientas</strong> sobre embarazo, primeros años, etapa escolar y adolescencia, así como temas de crianza, salud, alimentación, desarrollo y salud mental.
    </p>
    <p style="text-align: center; font-style: italic; color: #D94571; margin-top: 25px;">
      <strong>Todo en un solo lugar.</strong>
    </p>
  </div>
</div>

<!-- LO MÁS VISTO -->
<h2 class="section-title">Lo más visto del mes </h2>

<div class="cards-grid">
  <div class="card-item">
      <div class="card-img-container">
          <img src="img/foro2.jpg" alt="Sueño">
      </div>
    <div class="card-item-body">
      <h3>¿Es buena idea prohibir las redes sociales?</h3>
      <p>Si eres madre, padre, cuidador o educadores normali sentirse abrumado, sabes que prohibir puede limitar el acceso de adolescentes a las...</p>
      <a href="#" class="card-item-link">Seguir leyendo aquí ➜</a>
    </div>
  </div>

  <div class="card-item">
     <div class="card-img-container">
          <img src="../photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="card-item-body">
      <h3>Estrategias cotidianas de autocuidado</h3>
      <p>Cuando cuidas de ti también te ayudas a cuidar
 mejor de tu familia. Y no es egoísta: es una forma
 de estar mejor para acompañar a tus hijos e
 hijas con más calma, paciencia y cariño, incluso 
en los días más difíciles....</p>
      <a href="#" class="card-item-link">Seguir leyendo aquí ➜</a>
    </div>
  </div>
</div>

<!-- CONSEJOS PARA TI EN EL DÍA A DÍA -->
<h2 class="section-title">Consejos para ti en el día a día </h2>

<div class="consejos-grid">
  <div class="consejo-card">
    <div class="card-img-container">
          <img src="../photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="consejo-body">
      <h4>La salud mental en época pediátricas</h4>
      <p>Descubre estrategias para promover la salud mental y cómo identificar signos de problemas emocionales.</p>
      <a href="#" class="card-item-link">Leer más ➜</a>
    </div>
  </div>

  <div class="consejo-card">
    <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="consejo-body">
      <h4>Cómo ayudar a tu hij@s a atravesar una crisis</h4>
      <p>Consejos prácticos para apoyar emocionalmente a tus hijos durante momentos difíciles.</p>
      <a href="#" class="card-item-link">Leer más ➜</a>
    </div>
  </div>

  <div class="consejo-card">
    <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="consejo-body">
      <h4>Hábitos en el desarrollo de tu hij@ - VÍDEO</h4>
      <p>Aprende sobre los hábitos más importantes para el desarrollo saludable de tu hijo/a.</p>
      <a href="#" class="card-item-link">Ver video ➜</a>
    </div>
  </div>

  <div class="consejo-card">
    <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="consejo-body">
      <p>Estrategias y herramientas para criar en valores y promover la salud emocional desde el primer año de vida.</p>
      <a href="#" class="card-item-link">Leer más ➜</a>
    </div>
  </div>
</div>

<!-- ETAPAS -->
<div class="etapas-section">
  <h3>¿Qué estás buscando? </h3>
  <p style="color: #D94571; font-size: 16px; margin-bottom: 30px;">Ingresá a la etapa de tu interés:</p>
  
  <div class="etapas-buttons">
    <button class="etapa-btn">
      <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
      Embarazo
    </button>
    <button class="etapa-btn">
      <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
      Primeros años
    </button>
    <button class="etapa-btn">
      <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
      Pre-Adolescencia
    </button>
    <button class="etapa-btn">
      <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
      Adolescencia
    </button>
  </div>
</div>

<!-- GUÍAS PARA FAMILIAS -->
<h2 class="section-title">Guías para familias </h2>

<div class="guias-grid">
  <div class="guia-card">
    <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="guia-body">
      <h5>¿Mucho, poquito o nada?</h5>
      <p>Guía sobre nutrición infantil y opciones saludables para los primeros años de vida.</p>
      <a href="#" class="card-item-link">Leer más ➜</a>
    </div>
  </div>

  <div class="guia-card">
   <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="guia-body">
      <h5>Hola, bebé</h5>
      <p>Descubre el ambiente ideal para el primer año de vida y los primeros cuidados.</p>
      <a href="#" class="card-item-link">Leer más ➜</a>
    </div>
  </div>

  <div class="guia-card">
    <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="guia-body">
      <h5>Jugar, amar, compartir</h5>
      <p>Actividades y estrategias para fortalecer los vínculos familiares a través del juego.</p>
      <a href="#" class="card-item-link">Leer más ➜</a>
    </div>
  </div>

  <div class="guia-card">
    <div class="card-img-container">
          <img src="photos/foro2.jpg" alt="Sueño">
      </div>
    <div class="guia-body">
      <h5>Pantallas en casa</h5>
      <p>Guía completa sobre el uso responsable de pantallas e internet en el hogar familiar.</p>
      <a href="#" class="card-item-link">Leer más ➜</a>
    </div>
  </div>
</div>

<!-- FOOTER -->
<div class="footer">
  <div class="footer-logo">
    <i class="bi bi-heart-fill" style="font-size: 40px;"></i>
    <h2>Parently</h2>
  </div>
  <p style="margin-top: 20px; font-size: 16px;">
    Tu compañero de confianza en la crianza 
  </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
