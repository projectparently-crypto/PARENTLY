<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades</title>


    </style>
    <link rel="stylesheet" href="style/actividades.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
</head>
<body>

    <!-- NAVBAR -->

   <nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">

    <!-- Logo + nombre (izquierda) -->
    <a class="navbar-brand d-flex align-items-center" href="comunidades.php">
      <img src="img/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">
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
          <a class="nav-link" href="especialista_perfil.php">Especialistas</a>
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


    <!-- HERO -->

    <section class="hero">

        <div class="hero-text">

            <h1>CONECTAR, JUGAR Y APRENDER JUNTOS</h1>

            <p>
                Descubre ideas para disfrutar de tiempo en familia,
                estimular el desarrollo de tus hijos y fortalecer
                el vínculo parental.
            </p>

        </div>

    </section>

    <!-- TITULO -->

    <h1 class="titulo">Actividades</h1>

    <!-- BOTONES -->

    <div class="edades">

        <button class="edad-btn">0-3 años</button>
        <button class="edad-btn">4-6 años</button>
        <button class="edad-btn">7-9 años</button>
        <button class="edad-btn">9-12 años</button>
        <button class="edad-btn">+13 años</button>

    </div>

    <!-- CARDS -->

    <section class="contenedor-cards">

        <div class="card">

            <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Manualidades</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1511895426328-dc8714191300?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Juegos familiares</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Actividades al aire libre</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Lecturas compartidas</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Cocinar juntos</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Trivias</h3>
                <button>Ver más</button>
            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer class="specialist-footer">
        <img src="photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
        <strong>Parently</strong>
    </footer>

</body>
</html>