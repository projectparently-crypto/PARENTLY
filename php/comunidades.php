<?php
session_start();
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidades</title>

    <link rel="stylesheet" href="../style/comunidades.css">
    <link rel="stylesheet" href="../style/navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../photos/favicon.ico">
     <link rel="stylesheet" href="../style/recursos-detalle.css">
</head>
<body>
   <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="../index.php">
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
          <a class="nav-link" href="../actividades.php">Actividades</a>
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
 
 
<!-- IMAGEN + TEXTO ENCIMA -->
<div class="position-relative">
 
  <!-- Imagen -->
 
  <img src="../photos/_HispanicFamilyUS[1].jpg" class="w-100" height="750" alt="familia">
 
 
  <!-- Texto encima -->
    <div class="hero-text">
    <h1 class="title">No estás solo en la crianza</h1>
    <p class="subtitle">Descubre una comunidad pensada para apoyarte, escucharte y ayudarte a crecer como padre o madre.</p>
    </div>
</div>
<!-- AGE TABS -->
<div class="age-tabs">
  <div class="age-tabs__inner">
    <a href="comunidades.php?etapa=1" class="age-tab">0-3 años</a>
    <a href="comunidades.php?etapa=2" class="age-tab">4-6 años</a>
    <a href="comunidades.php?etapa=3" class="age-tab">7-9 años</a>
    <a href="comunidades.php?etapa=4" class="age-tab">10-12 años</a>
    <a href="comunidades.php?etapa=5" class="age-tab">13+ años</a>
  </div>
</div>
<section class="foros-section" id="foros">
  <div class="page">
    <div class="section-header">
      <div class="section-title">
        <small>Explora</small>
        Foros
      </div>
      <a href="comunidad.php" class="btn-white">Ver más</a>
    </div>
 
 <div class="container my-5">
    <div class="row g-4">
  
    <?php
    include("conexion.php");

      $etapa = $_GET['etapa'] ?? 1;

      $sql = "SELECT * FROM foros1 WHERE id_etapa = $etapa";

      $resultado = mysqli_query($conexion, $sql);

      while($foro = mysqli_fetch_assoc($resultado)){
    ?>

        <div class="col-md-6">
            <div class="card border-0 h-100">

                <div class="card-img-container">
                    <img src="<?php echo $foro['imagen']; ?>" alt="<?php echo $foro['nombre']; ?>">
                </div>

                <div class="card-body">

                    <span class="badge rounded-pill px-3 py-2 mb-3"
                        style="background:<?php echo $foro['color_fondo']; ?>;
                               color:<?php echo $foro['color_texto']; ?>;">
                        <?php echo $foro['categoria']; ?>
                    </span>

                    <h5 class="fw-bold">
                        <?php echo $foro['nombre']; ?>
                    </h5>

                    <p class="text-muted small">
                        <?php echo $foro['descripcion']; ?>
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-4">

                        <a href="foro.php?id=<?php echo $foro['id_foro']; ?>"
                           class="btn btn-verde px-2">
                            VER MÁS
                        </a>

                        <a href="unirse_foro.php?id=<?php echo $foro['id_foro']; ?>"
                           class="btn btn-turquesa px-4">
                            UNIRSE
                        </a>

                    </div>

                </div>

            </div>
        </div>

    <?php } ?>
    
<!-- ── APRENDE EN COMUNIDAD ──────────────────────────────────────── -->
<section class="preguntas-section" id="aprende">

    <div class="page">

        <div class="section-header" style="margin-bottom:2rem;">

            <div class="section-title">
                <small>Comunidad</small>
                Aprende en Comunidad
            </div>

            <a href="aprendecomunidad.php" class="btn-white">
                Ver todas
            </a>

        </div>

<?php

include("conexion.php");

$sql = "SELECT *
        FROM situaciones
        WHERE fecha_publicacion <= CURDATE()
        ORDER BY fecha_publicacion DESC
        LIMIT 1";

$resultado = mysqli_query($conexion,$sql);

while($fila = mysqli_fetch_assoc($resultado)){

?>

<div class="pregunta-item">

    <div class="pregunta-user">

        <div class="avatar">
            <i class="bi bi-lightbulb-fill"></i>
        </div>

        <div>

            <div class="pregunta-user-name">
                Situación de la semana
            </div>

            <div class="pregunta-user-time">
                <?php echo date("d/m/Y", strtotime($fila['fecha_publicacion'])); ?>
            </div>

        </div>

    </div>

    <h4 style="margin-top:15px; color:#2C4A7C;">
        <?php echo htmlspecialchars($fila['titulo']); ?>
    </h4>

    <p class="pregunta-text">
        <?php echo nl2br(htmlspecialchars($fila['descripcion'])); ?>
    </p>

    <a href="aprendecomunidad.php?id=<?php echo $fila['id_situacion']; ?>"
       class="btn-responder">

        Ver situación

    </a>

</div>

<?php

}

?>

    </div>

</section>

<!-- ═════════════ EXPERIENCIAS (VISTA PREVIA) ═════════════ -->
<section class="experiencias-section" id="experiencias">

<div class="page">

    <div class="section-header" style="margin-bottom:2rem;">

        <div class="section-title">
            <small>Comunidad</small>
            Experiencias
        </div>

        <a href="experiencias.php" class="btn-white">
            Ver todas
        </a>

    </div>

<?php

include("conexion.php");

$sql = "SELECT

e.*,

c.nombre AS categoria,

COALESCE(SUM(r.tipo='identifica'),0) AS identifica,

COALESCE(SUM(r.tipo='conmueve'),0) AS conmueve,

COALESCE(SUM(r.tipo='ayudo'),0) AS ayudo,

(
SELECT COUNT(*)
FROM comentarios_experiencias co
WHERE co.id_experiencia=e.id_experiencia
) AS comentarios

FROM experienciasform e

LEFT JOIN categorias_experiencias c
ON e.id_categoria=c.id_categoria

LEFT JOIN reacciones_experiencias r
ON r.id_experiencia=e.id_experiencia

GROUP BY e.id_experiencia

ORDER BY e.fecha_publicacion DESC

LIMIT 2";

$resultado = mysqli_query($conexion,$sql);

?>

<section class="experiencias">

<?php while($fila=mysqli_fetch_assoc($resultado)){ ?>

<div class="card-experiencia">

    <div class="linea-azul"></div>

    <div class="header-exp">

        <div class="usuario">

            <div class="avatar">

                <?php
                echo strtoupper(substr($fila["nombre_autor"],0,1));
                ?>

            </div>

            <div>

                <h3>

                    <?php
                    echo htmlspecialchars($fila["nombre_autor"]);
                    ?>

                </h3>

                <span>

                    <?php

                    $diff=time()-strtotime($fila["fecha_publicacion"]);

                    if($diff<60){

                        echo "Hace un momento";

                    }elseif($diff<3600){

                        echo "Hace ".floor($diff/60)." min";

                    }elseif($diff<86400){

                        echo "Hace ".floor($diff/3600)." h";

                    }else{

                        echo date("d/m/Y",strtotime($fila["fecha_publicacion"]));

                    }

                    if(!empty($fila["ciudad"])){

                        echo " · ".htmlspecialchars($fila["ciudad"]);

                    }

                    ?>

                </span>

            </div>

        </div>

        <span class="categoria">

            <?= htmlspecialchars(strtoupper($fila["categoria"])) ?>

        </span>

    </div>

    <h2 class="titulo">

        <?= htmlspecialchars($fila["titulo"]) ?>

    </h2>

    <p class="contenido">

        <?= nl2br(htmlspecialchars(substr($fila["contenido"],0,220))) ?>...

    </p>

    <hr>

    <div class="acciones">

        <button
        class="btn-reaccion"
        disabled>

        🤝 Me identifica

        <strong><?= $fila["identifica"] ?></strong>

        </button>

        <button
        class="btn-reaccion"
        disabled>

        ❤️ Me conmueve

        <strong><?= $fila["conmueve"] ?></strong>

        </button>

        <button
        class="btn-reaccion"
        disabled>

        💡 Me ayudó

        <strong><?= $fila["ayudo"] ?></strong>

        </button>

        <button
        class="btn-comentarios"
        disabled>

        💬 <?= $fila["comentarios"] ?>

        </button>

    </div>

</div>

<?php } ?>

</section>

</div>

</section>

<<<<<<< HEAD
<!-- FOOTER -->
<footer class="footer">
  <div class="footer-container">
    <div class="footer-logo">
     <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="logo">
    </div>
    <div class="footer-content">
      <h2>Contáctanos:</h2>
      <div class="footer-links">
        <div class="footer-column">
          <p>
            <a href="https://www.instagram.com/parently_team" class="footer-link">
              <i class="bi bi-instagram"></i> Instagram
            </a>
          </p>
          <p>
            <a href="https://whatsapp.com/channel/0029VbD4Q1CEawdpYOZHis1g" class="footer-link">
              <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
          </p>
        </div>
        <div class="footer-column">
          <p>
            <a href="mailto:contacto@parently.com" class="footer-link">
              <i class="bi bi-envelope"></i> Correo
            </a>
          </p>
          <p>
            <a href="https://www.facebook.com/parently" class="footer-link">
              <i class="bi bi-facebook"></i> Facebook
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
=======
>>>>>>> 5088e9eba405b6371fa93f33f93241fa018ae511


<script src="../experiencias.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
