<?php
session_start();
include("conexion.php");
include("comunidad_schema.php");

asegurar_comunidad_schema($conexion);
$usuarioActual = usuario_actual_id();
$esAdmin = usuario_es_admin();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas | Parently</title>

    <link rel="stylesheet" href="../style/preguntas.css">
    <link rel="stylesheet" href="../style/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
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
        <li class="nav-item"><a class="nav-link" href="recursos.php">Recursos</a></li>
        <li class="nav-item"><a class="nav-link" href="actividades.php">Actividades</a></li>
        <li class="nav-item"><a class="nav-link" href="especialistas.php">Especialistas</a></li>
        <li class="nav-item"><a class="nav-link" href="comunidades.php">Comunidades</a></li>
        <li class="nav-item"><a class="nav-link" href="contactanos.php">Contactanos</a></li>
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
            <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesion</a>
          </div>
        <?php else: ?>
          <a href="login.php" class="btn btn-outline-success">Iniciar Sesion</a>
          <a href="registro.php" class="btn btn-success">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<header class="hero">
  <h1>Un lugar para compartir <span>tus dudas</span></h1>
  <p>Aqui cada pregunta importa. Expresa tus dudas, recibe respuestas y comparte aprendizajes con quienes recorren caminos similares.</p>
</header>

<main class="preguntas-page">
  <section class="intro-preguntas">
    <div>
      <span class="eyebrow">Comunidad</span>
      <h2>Preguntas recientes</h2>
      <p>
        Cada duda merece respeto y atencion. Comparte lo que estas viviendo y
        encuentra apoyo de otras familias.
      </p>
    </div>
  </section>

  <section class="form-pregunta">
    <h2>Haz una pregunta</h2>

    <form action="guardar_pregunta.php" method="POST">
      <textarea
        name="pregunta"
        placeholder="Escribe aqui tu duda..."
        required></textarea>

      <button type="submit">
        <i class="bi bi-send-fill"></i>
        Publicar pregunta
      </button>
    </form>
  </section>

  <section class="lista-preguntas">
    <?php
      $sql = "SELECT p.*,
              (SELECT COUNT(*) FROM respuestasc r WHERE r.id_pregunta = p.id_pregunta) AS total_respuestas,
              (SELECT COUNT(*) FROM reacciones_preguntas rp WHERE rp.id_pregunta = p.id_pregunta AND rp.tipo = 'interesa') AS cnt_interesa,
              (SELECT COUNT(*) FROM reacciones_preguntas rp WHERE rp.id_pregunta = p.id_pregunta AND rp.tipo = 'ayuda') AS cnt_ayuda
              FROM preguntasc p
              ORDER BY p.fecha DESC";

      $resultado = mysqli_query($conexion, $sql);

      if (!$resultado) {
          echo "<p class='estado-vacio'>No se pudieron cargar las preguntas.</p>";
      } elseif (mysqli_num_rows($resultado) === 0) {
          echo "<p class='estado-vacio'>Aun no hay preguntas. Se la primera persona en compartir una duda.</p>";
      }

      while($resultado && $fila = mysqli_fetch_assoc($resultado)){
          $pregunta = htmlspecialchars($fila['pregunta']);
          $fecha = !empty($fila['fecha']) ? date('d/m/Y', strtotime($fila['fecha'])) : 'Reciente';
          $idPregunta = (int)$fila['id_pregunta'];
          $autorId = (int)($fila['id_usuario'] ?? 0);
          $puedeModificar = $esAdmin || ($usuarioActual > 0 && $autorId === $usuarioActual);
    ?>

    <article class="card-pregunta" id="pregunta-<?php echo $idPregunta; ?>">
      <div class="header-pregunta">
        <div class="usuario">
          <div class="avatar">
            <i class="bi bi-person-fill"></i>
          </div>

          <div>
            <h3>Usuario</h3>
            <span><?php echo $fecha; ?></span>
          </div>
        </div>

        <div class="header-actions">
          <span class="etiqueta-pregunta">
            Pregunta<?php echo !empty($fila['editado']) ? ' editada' : ''; ?>
          </span>

          <div class="menu-pregunta">
            <button
              type="button"
              class="btn-menu-pregunta"
              onclick="toggleMenuPregunta(<?php echo $idPregunta; ?>)"
              aria-label="Opciones">
              <i class="bi bi-three-dots-vertical"></i>
            </button>

            <div class="dropdown-menu-pregunta" id="menu-pregunta-<?php echo $idPregunta; ?>">
              <?php if ($puedeModificar): ?>
                <button type="button" onclick="toggleEditarPregunta(<?php echo $idPregunta; ?>)">
                  <i class="bi bi-pencil"></i>
                  Editar
                </button>

                <form action="accion_pregunta.php" method="POST" onsubmit="return confirm('Eliminar esta pregunta?')">
                  <input type="hidden" name="id_pregunta" value="<?php echo $idPregunta; ?>">
                  <input type="hidden" name="accion" value="eliminar">
                  <button type="submit">
                    <i class="bi bi-trash"></i>
                    Eliminar
                  </button>
                </form>
              <?php else: ?>
                <form action="accion_pregunta.php" method="POST">
                  <input type="hidden" name="id_pregunta" value="<?php echo $idPregunta; ?>">
                  <input type="hidden" name="accion" value="denunciar">
                  <button type="submit">
                    <i class="bi bi-flag"></i>
                    Denunciar
                  </button>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <h2 class="titulo-pregunta">
        <?php echo $pregunta; ?>
      </h2>

      <?php if ($puedeModificar): ?>
        <form class="form-editar-pregunta" id="editar-pregunta-<?php echo $idPregunta; ?>" action="accion_pregunta.php" method="POST">
          <input type="hidden" name="id_pregunta" value="<?php echo $idPregunta; ?>">
          <input type="hidden" name="accion" value="editar">
          <textarea name="pregunta" required><?php echo $pregunta; ?></textarea>
          <div class="editar-actions">
            <button type="submit" class="btn-responder">Guardar</button>
            <button type="button" class="btn-cancelar-pregunta" onclick="toggleEditarPregunta(<?php echo $idPregunta; ?>)">Cancelar</button>
          </div>
        </form>
      <?php endif; ?>

      <div class="acciones">
        <button
          type="button"
          class="btn-reaccion-pregunta"
          data-pregunta="<?php echo $idPregunta; ?>"
          data-tipo="interesa"
          onclick="reaccionarPregunta(this)">
          <i class="bi bi-heart"></i>
          Me interesa
          <strong class="cnt"><?php echo (int)$fila['cnt_interesa']; ?></strong>
        </button>

        <button
          type="button"
          class="btn-reaccion-pregunta"
          data-pregunta="<?php echo $idPregunta; ?>"
          data-tipo="ayuda"
          onclick="reaccionarPregunta(this)">
          <i class="bi bi-lightbulb"></i>
          Me ayuda
          <strong class="cnt"><?php echo (int)$fila['cnt_ayuda']; ?></strong>
        </button>

        <button type="button">
          <i class="bi bi-chat-dots"></i>
          Respuestas
          <strong><?php echo (int)$fila['total_respuestas']; ?></strong>
        </button>
      </div>

      <form class="form-respuesta" action="guardar_respuesta.php" method="POST">
        <input type="hidden" name="id_pregunta" value="<?php echo $idPregunta; ?>">
        <input type="hidden" name="redirect" value="preguntas.php">

        <textarea
          name="respuesta"
          placeholder="Escribe una respuesta..."
          required></textarea>

        <button type="submit" class="btn-responder">
          Responder
        </button>
      </form>

      <?php
        $sqlRes = "SELECT *
                   FROM respuestasc
                   WHERE id_pregunta = $idPregunta
                   ORDER BY fecha ASC
                   LIMIT 2";

        $respuestas = mysqli_query($conexion, $sqlRes);

        while($respuesta = mysqli_fetch_assoc($respuestas)){
      ?>

        <div class="respuesta-card">
          <div class="respuesta-label">Respuesta</div>
          <p class="respuesta-text">
            <?php echo nl2br(htmlspecialchars($respuesta['respuesta'])); ?>
          </p>
        </div>

      <?php } ?>
    </article>

    <?php } ?>
  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="../preguntas.js"></script>
</body>
</html>
