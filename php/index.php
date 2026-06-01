<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parently</title>
    <link rel="stylesheet" href="../style/homepage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

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

<div class="hero position-relative">

  <!-- Imagen -->
  <img src="../photos/cheapest_places_to_live_on_the_west_coast__4088x2725___v1222x580.jpg" class="hero-img" alt="familia">

  <!-- Capa oscura -->
  <div class="overlay"></div>

  <!-- Texto -->
  <div class="hero-text">
    <h1 class="title">GUÍA PARA <span>PADRES</span></h1>
    <p class="subtitle">Consejos reales para tu familia.</p>

    <button class="hero-btn">Empezar ahora</button>
  </div>

</div>

<section class="intro">
  <h2>
    Apoyando a los <span>padres</span>
  </h2>

  <h3>construyendo mejores futuros</h3>

  <p>
    Descubre herramientas, orientación y una comunidad de apoyo diseñadas
    para ayudarte a transitar la paternidad con confianza y cuidado.
  </p>
</section>

<div class="about-section">

  <!-- TEXTO EN RECUADRO -->
  <div class="about-card">

    <div class="about-content">
      <h3>¿QUIÉNES SOMOS?</h3>

      <p>
        Somos una guía para apoyar a los padres en la crianza de sus hijos,
        brindando orientación y consejos prácticos en cada etapa de su desarrollo.

        Ofrecemos información clara y accesible que ayuda a comprender sus
        necesidades y a fortalecer la relación familiar, promoviendo una crianza
        basada en el amor, la comunicación y la confianza.
      </p>
    </div>

  </div>

  <!-- IMAGEN FUERA -->
  <div class="about-img">
    <img src="../photos/保育園_幼稚園の運動会大成功アイデア集_年齢別種目_親子競技編__保育のお仕事レポート-removebg-preview (1).png" alt="happy family">
  </div>

</div>


 <div class="row justify-content-center mb-5 mission-section">

  <!-- MISIÓN -->
  <div class="col-md-4">
    <div class="mission-card">

      <div class="card-body">

        <h3>MISIÓN</h3>

        <i class="fa-solid fa-lightbulb mission-icon"></i>

        <p>
          Brindar a los padres una guía confiable y accesible que les ayude
          en la crianza de sus hijos, ofreciendo orientación, herramientas
          prácticas y contenido claro que fortalezca la comunicación,
          el aprendizaje y el bienestar familiar.
        </p>

      </div>
    </div>
  </div>

  <!-- VISIÓN -->
  <div class="col-md-4">
    <div class="mission-card">

      <div class="card-body">

        <h3>VISIÓN</h3>

        <i class="fa-solid fa-eye mission-icon"></i>

        <p>
          Ser una guía reconocida que acompañe a las familias en su crecimiento,
          promoviendo una crianza consciente basada en el amor, el respeto y
          la confianza, y contribuyendo al desarrollo integral de los niños.
        </p>

      </div>
    </div>
  </div>

</div>

<section class="features">

  <h2>¿Por qué elegir Parently?</h2>

  <div class="feature-grid">

    <div class="feature">
      <i class="bi bi-rocket-takeoff"></i>
      <h4>Listo para usar</h4>
      <p>Empieza a usar Parently al instante, sin configuraciones complicadas.</p>
    </div>

    <div class="feature">
      <i class="bi bi-check2-circle"></i>
      <h4>Fácil de usar</h4>
      <p>Diseño simple e intuitivo para que puedas navegar sin estrés.</p>
    </div>

    <div class="feature">
      <i class="bi bi-people"></i>
      <h4>Apoyo real</h4>
      <p>Obtén orientación, consejos y una comunidad de apoyo cuando lo necesites.</p>
    </div>

  </div>

</section>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>

const hiddenElements = document.querySelectorAll('.card, .feature');

const observer = new IntersectionObserver((entries) => {

    entries.forEach((entry) => {

        if(entry.isIntersecting){
            entry.target.classList.add('show');
        }

    });

});

hiddenElements.forEach((el) => {

    el.classList.add('hidden');
    observer.observe(el);

});

</script>
<!-- FOOTER -->
<footer class="footer">

  <div class="footer-container">

    <!-- IMAGEN / LOGO -->
    <div class="footer-logo">

      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="logo">

    </div>

    <!-- TEXTO -->
    <div class="footer-content">

      <h2>Contáctanos:</h2>

      <div class="footer-links">

        <!-- IZQUIERDA -->
        <div class="footer-column">

          <p>
            <a href="https://www.instagram.com/parently_team?igsh=d251dXlzcnF4anp5" class="footer-link">
              <i class="bi bi-instagram"></i>
              Instagram:
            </a>
          </p>

          <p>
            <a href="https://whatsapp.com/channel/0029VbD4Q1CEawdpYOZHis1g" class="footer-link">
              <i class="bi bi-whatsapp"></i>
              WhatsApp:
            </a>
          </p>

        </div>

        <!-- DERECHA -->
        <div class="footer-column">

          <p>
            <a href="mailto:tucorreo@gmail.com" class="footer-link">
              <i class="bi bi-envelope"></i>
              Correo:
            </a>
          </p>

          <p>
            <a href="https://www.facebook.com/share/g/1CgdV2AhZ4/" class="footer-link">
              <i class="bi bi-facebook"></i>
              Facebook:
            </a>
          </p>

        </div>

      </div>

    </div>

  </div>

</footer>
</body>
</html>
