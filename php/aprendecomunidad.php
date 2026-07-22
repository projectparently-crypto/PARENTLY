<?php
session_start();
include("conexion.php");
include("comunidad_schema.php");

asegurar_comunidad_schema($conexion);

$usuarioActual = usuario_actual_id();
$esAdmin = usuario_es_admin();
// Obtener la situación publicada más reciente
$sql = "SELECT *
        FROM situaciones
        WHERE fecha_publicacion <= CURDATE()
        ORDER BY fecha_publicacion DESC
        LIMIT 1";

$resultado = mysqli_query($conexion, $sql);

$situacion = mysqli_fetch_assoc($resultado);

if(!$situacion){
    die("No hay situaciones disponibles.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Aprende en Comunidad | PARENTLY</title>

    <link rel="stylesheet" href="../style/aprendesc.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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

<header class="hero">

    <h1>
        ¿Qué harías <span>en esta situación?</span>
    </h1>


    <p>
        Descubre desafíos cotidianos de la crianza, reflexiona sobre cómo actuarías,
        compara tu respuesta con la de otros padres y fortalece tus habilidades
        mediante el aprendizaje en comunidad.
    </p>

</header>


<h1>

    <main class="container py-5">

        <div class="card-situacion">

    <span class="badge bg-warning text-dark">
        Situación de la semana
    </span>

        <h3>
        <?= htmlspecialchars($situacion["titulo"]); ?>
        </h3>

        <p>
        <?= nl2br(htmlspecialchars($situacion["descripcion"])); ?>
        </p>

        <video controls width="100%">
        <source src="<?= htmlspecialchars($situacion["video"]); ?>" type="video/mp4">
        </video>

   <form id="formRespuesta">

    <input type="hidden" name="situacion" value="1">

    <input
type="hidden"
name="id_situacion"
value="<?= $situacion["id_situacion"]; ?>">

<?php

$opciones = mysqli_query($conexion,

"SELECT *
FROM opciones_situacion
WHERE id_situacion=".$situacion["id_situacion"]);

while($opcion=mysqli_fetch_assoc($opciones)){

?>

<label class="opcion">

<input
type="radio"
name="id_opcion"
value="<?= $opcion["id_opcion"]; ?>"
required>

<?= htmlspecialchars($opcion["texto"]); ?>

</label>

<?php } ?>

<?php

$consultaOpciones = mysqli_query(

$conexion,

"SELECT *
FROM opciones_situacion
WHERE id_situacion=".$situacion["id_situacion"]);

while($opcion=mysqli_fetch_assoc($consultaOpciones)){

?>



<?php } ?>

        <button
        type="submit"
        class="btn btn-warning mt-4"
        id="btnResponder">

        Responder

        </button>

</form>

<!-- Mensaje de agradecimiento -->

<div id="mensajeRespuesta" class="mensaje-respuesta d-none">

    <div class="check-circle">
        <i class="fa-solid fa-check"></i>
    </div>

    <h3>¡Gracias por participar!</h3>

    <p>
        Tu respuesta ahora forma parte de esta comunidad.
        Conoce cómo respondieron otros padres.
    </p>

</div>


<div id="reflexion" class="reflexion-card d-none">

    <div id="iconoReflexion" class="icono-reflexion">
        🧠
    </div>

    <h3 id="tituloReflexion">
        Reflexionemos juntos
    </h3>

    <p id="textoReflexion"></p>

    <button
        class="btn btn-primary mt-3"
        id="btnVerResultados">

        Ver cómo respondió la comunidad

    </button>

</div>

<div class="historial-card">

    <h3>Situaciones anteriores</h3>

    <p>

        Descubre situaciones que otros padres ya respondieron
        y conoce cómo reaccionó la comunidad.

    </p>

    <a href="situaciones.php"
       class="btn btn-primary">

       Ver historial

    </a>

</div>

<!-- Resultados -->

<div id="resultados" class="resultados d-none">

    <h2>📊 ¿Cómo respondió la comunidad?</h2>

    <div class="barra">

        <span>Hablar con calma</span>

        <div class="progress">

            <div class="progress-bar barra1"
                 data-width="68">
            </div>

        </div>

        <small>68%</small>

    </div>

    <div class="barra">

        <span>Escuchar primero</span>

        <div class="progress">

            <div class="progress-bar barra2"
                 data-width="20">
            </div>

        </div>

        <small>20%</small>

    </div>

    <div class="barra">

        <span>Castigar</span>

        <div class="progress">

            <div class="progress-bar barra3"
                 data-width="8">
            </div>

        </div>

        <small>8%</small>

    </div>

    <div class="barra">

        <span>Ignorar</span>

        <div class="progress">

            <div class="progress-bar barra4"
                 data-width="4">
            </div>

        </div>

        <small>4%</small>

    </div>

</div>

</div>

    </main>

    <script src="../aprendec.js"></script>

</body>
</html>