<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidades</title>

    <link rel="stylesheet" href="../style/preguntas.css">
    <link rel="stylesheet" href="../style/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    

</head>
<body>
   <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">
      Parently
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
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
      <div class="d-flex gap-2 align-items-center">
        <?php if (isset($_SESSION["usuario_nombre"])): ?>
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
          <a href="login.php" class="btn btn-outline-success">Iniciar Sesión</a>
          <a href="registro.php" class="btn btn-success">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
 
<div class="hero position-relative">

<!-- HERO -->
<header class="hero">
  <h1>Un lugar para compartir <span>tus dudas</span></h1>
  <p>Aquí cada pregunta importa. Expresa tus dudas, recibe respuestas y comparte aprendizajes con quienes recorren caminos similares.</p>
</header>
</body>
 