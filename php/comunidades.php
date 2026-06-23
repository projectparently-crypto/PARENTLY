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
 
 
<!-- IMAGEN + TEXTO ENCIMA -->
<div class="position-relative">
 
  <!-- Imagen -->
 
  <img src="../photos/photo_5019457631378148225_y.jpg" class="w-100" height="750" alt="familia">
 
 
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
    
<!-- ── PREGUNTAS ──────────────────────────────────────── -->
 <!-- Hacer una pregunta -->
 
<?php

include("conexion.php");

$sql = "SELECT *
        FROM preguntasc
        ORDER BY fecha DESC
        LIMIT 1";

$resultado = mysqli_query($conexion, $sql);

while($fila = mysqli_fetch_assoc($resultado)){

?>

<div class="pregunta-item">

    <div class="pregunta-user">

        <div class="avatar">
            <i class="bi bi-person-circle"></i>
        </div>

        <div>

            <div class="pregunta-user-name">
                Usuario
            </div>

            <div class="pregunta-user-time">
                <?php echo $fila['fecha']; ?>
            </div>

        </div>

    </div>

    <p class="pregunta-text">
        "<?php echo $fila['pregunta']; ?>"
    </p>

    <form
        action="guardar_respuesta.php"
        method="POST">

        <input
            type="hidden"
            name="id_pregunta"
            value="<?php echo $fila['id_pregunta']; ?>">

        <textarea
            name="respuesta"
            placeholder="Escribe una respuesta..."
            required>
        </textarea>

        <br><br>

        <button
            type="submit"
            class="btn-responder">
            Responder
        </button>

    </form>

<?php

$id = $fila['id_pregunta'];

$sqlRes = "SELECT *
           FROM respuestasc
           WHERE id_pregunta = $id
           ORDER BY fecha ASC
           LIMIT 2";

$respuestas = mysqli_query(
    $conexion,
    $sqlRes
);

while($respuesta = mysqli_fetch_assoc($respuestas)){

?>

    <div class="respuesta-card">

        <div class="respuesta-label">
            RESPUESTA
        </div>

        <p class="respuesta-text">
            <?php echo $respuesta['respuesta']; ?>
        </p>

    </div>

<?php

}

?>

</div>

<?php

}

?>

</body>
</html>