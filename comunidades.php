<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidades</title>
        <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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


<!-- IMAGEN + TEXTO ENCIMA -->
<div class="position-relative">

  <!-- Imagen -->
  <img src="img/comunidadesP.jpg" class="w-100" height="750" alt="familia">

  <!-- Texto encima -->
  <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
    <h1 class="fw-bold">No estás solo en la crianza </h1>
    <p>Descubre una comunidad pensada para apoyarte, escucharte y ayudarte a crecer como padre o madre.</p>
    <button class="btn btn-success">Empezar ahora</button>
  </div>

</div>
<!-- AGE TABS -->
<div class="age-tabs">
  <div class="age-tabs__inner">
    <button class="age-tab">0–3 años</button>
    <button class="age-tab">4–6 años</button>
    <button class="age-tab">7–9 años</button>
    <button class="age-tab">9–12 años</button>
    <button class="age-tab">+13 años</button>
  </div>
</div>
<section class="foros-section" id="foros">
  <div class="page">
    <div class="section-header">
      <div class="section-title">
        <small>Explora</small>
        Foros
      </div>
    </div>
 
    <!-- Banner conversaciones -->
    <div class="banner-conversaciones">
      <div class="banner-conversaciones__left">
        <div>
          <div class="banner-conversaciones__title">Conversaciones</div>
          <div class="banner-conversaciones__sub">Únete a los debates más activos del momento</div>
        </div>
      </div>
      <a href="comunidades.html" class="btn-white">Ver más</a>
    </div>
 <!-- Grid de foros -->

<div class="container my-5">
    <div class="row g-4">

        <!-- CARD 1 -->
        <div class="col-md-6">
            <div class="card border-0 h-100">

                <div class="card-img-container">
                    <img src="img/foro1.jpg" alt="Sueño">
                </div>

                <div class="card-body">

                    <span class="badge rounded-pill px-3 py-2 mb-3"
                        style="background:#dff8f5; color:#20c9b7;">
                        SUEÑO
                    </span>

                    <h5 class="fw-bold">Hábitos de sueño</h5>

                    <p class="text-muted small">
                        Sección enfocada en resolver problemas relacionados con el descanso y las rutinas de sueño de los hijos.
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-4">

                        <button class="btn btn-verde px-2">
                            VER MAS
                        </button>

                        <button class="btn btn-turquesa px-4">
                            UNIRSE
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="col-md-6">
            <div class="card border-0 h-100">

                <div class="card-img-container">
                    <img src="img/foro2.jpg" alt="Sueño">
                </div>

                <div class="card-body">

                    <span class="badge rounded-pill px-3 py-2 mb-3"
                        style="background:#fff0e4; color:#ff8a3d;">
                        ALIMENTACIÓN
                    </span>

                    <h5 class="fw-bold">Nutrición y comida</h5>

                    <p class="text-muted small">
                        Espacio dedicado a dudas y consejos sobre hábitos alimenticios, nutrición y conductas relacionadas con la comida.
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-4">

                        <button class="btn btn-verde px-2">
                            VER MAS
                        </button>

                        <button class="btn btn-naranja px-4">
                            UNIRSE
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col-md-6">
            <div class="card border-0 h-100">

                <div class="card-img-container">
                    <img src="img/foro3.jpg" alt="Sueño">
                </div>

                <div class="card-body">

                    <span class="badge rounded-pill px-3 py-2 mb-3"
                        style="background:#f1ebff; color:#7a56d6;">
                        TECNOLOGÍA
                    </span>

                    <h5 class="fw-bold">Pantallas y tecnología</h5>

                    <p class="text-muted small">
                        Espacio para discutir el uso de dispositivos electrónicos, control del tiempo en pantalla y educación digital.
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-4">

                        <button class="btn btn-verde px-2">
                            VER MAS
                        </button>

                        <button class="btn btn-morado px-4">
                            UNIRSE
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="col-md-6">
            <div class="card border-0 h-100">

                <div class="card-img-container">
                    <img src="img/foro4.jpg" alt="Sueño">
                </div>

                <div class="card-body">

                    <span class="badge rounded-pill px-3 py-2 mb-3"
                        style="background:#e8f8ea; color:#3c9d47;">
                        EDUCACIÓN
                    </span>

                    <h5 class="fw-bold">Aprendizaje escolar</h5>

                    <p class="text-muted small">
                        Sección enfocada en temas académicos, rendimiento escolar y situaciones relacionadas con la educación.
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-4">


                        <button class="btn btn-verde px-2">
                            VER MAS
                        </button>

                        <button class="btn btn-verde px-4">
                            UNIRSE
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- ── PREGUNTAS ──────────────────────────────────────── -->
<section class="preguntas-section" id="preguntas">
  <div class="page">
    <div class="section-header" style="margin-bottom:2rem;">
      <div class="section-title">
        <small>Comunidad</small>
        Preguntas
      </div>
      <a href="#" class="btn-link">Ver todas </a>
    </div>
 
    <div class="preguntas-layout">
      <!-- Pregunta con respuesta -->
      <div class="pregunta-card">
        <div class="pregunta-card__header">
          <span style="font-size:1.2rem;">❓</span>
          <span class="pregunta-card__header-title">Resuelve tus dudas</span>
        </div>
 
        <div class="pregunta-item">
          <div class="pregunta-user">
            <div class="avatar" style="background:linear-gradient(135deg,#FF8FAB,var(--rose));">PG</div>
            <div>
              <div class="pregunta-user-name">Paula Gutiérrez</div>
              <div class="pregunta-user-time">hace 2 horas</div>
            </div>
          </div>
          <p class="pregunta-text">"¿A qué edad debería empezar a enseñarle a mi hija sobre el dinero?"</p>
          <button class="btn-responder">Responder</button>
 
          <div class="respuesta-card">
            <div class="respuesta-label">Respuestas</div>
            <div class="pregunta-user" style="margin-bottom:8px;">
              <div class="avatar" style="width:30px;height:30px;font-size:.72rem;background:linear-gradient(135deg,#FFB74D,var(--amber));">AR</div>
              <div>
                <div class="pregunta-user-name" style="font-size:.8rem;">Ana Rodríguez</div>
              </div>
            </div>
            <p class="respuesta-text">En mi caso empecé como a los 5 años, pero con algo básico. Le daba una pequeña cantidad a la semana y lo explicaba que si gastaba todo de una vez, ya no iba a tener después. Al inicio no lo entendía mucho 😅, pero con el tiempo empezó a ahorrar para comprarse cosas que quería.</p>
            <div class="respuesta-likes">❤ 12 me gusta</div>
          </div>
        </div>
 
        <div class="pregunta-item">
          <div class="pregunta-user">
            <div class="avatar" style="background:linear-gradient(135deg,#80CBC4,var(--teal));">ML</div>
            <div>
              <div class="pregunta-user-name">Marco López</div>
              <div class="pregunta-user-time">hace 5 horas</div>
            </div>
          </div>
          <p class="pregunta-text">"Mi hijo de 4 años tiene rabietas constantes en el supermercado, ¿qué hago?"</p>
          <button class="btn-responder">Responder</button>
        </div>
      </div>
 
      <!-- Hacer una pregunta -->
        <div class="pregunta-card">

            <div class="pregunta-titulo">
                ¿Tienes una pregunta?
            </div>

            <div class="pregunta-texto">
                La comunidad está aquí para ayudarte
            </div>

            <textarea class="pregunta-textarea"
                placeholder="Escribe tu pregunta aquí..."></textarea>

            <button class="btn-rose pregunta-btn">
                Publicar pregunta
            </button>

        </div>
 
        <div class="preguntas-populares">

    <div class="preguntas-titulo">
        Preguntas populares
    </div>

    <div class="preguntas-lista">

        <a href="#" class="pregunta-link">
            <span class="pregunta-punto">●</span>
            ¿Cómo manejar los berrinches sin perder la calma?
        </a>

        <a href="#" class="pregunta-link">
            <span class="pregunta-punto">●</span>
            ¿Cuántas horas de pantalla son aceptables a los 6 años?
        </a>

        <a href="#" class="pregunta-link">
            <span class="pregunta-punto">●</span>
            Mi hijo no quiere ir a la escuela, ¿qué puedo hacer?
        </a>

    </div>

</div>
      </div>
    </div>
  </div>
</section>
</body>
</html>