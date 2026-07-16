<?php
// experiencias.php
session_start();
include("conexion.php");
$filtro_categoria = isset($_GET['categoria'])
    ? (int)$_GET['categoria']
    : 0;

// ── Mensaje flash (tras guardar o reaccionar) ──────────────
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Experiencias | Parently</title>
  <link rel="stylesheet" href="../style/navbar.css">
  <link rel="stylesheet" href="../style/experiencias.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="icon" type="image/x-icon" href="../photos/favicon.ico">
</head>
<body>

<!-- ═══════════════════════════════ NAVBAR ═══════════════════════════════ -->
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
        <li class="nav-item"><a class="nav-link" href="recursos.php">Recursos</a></li>
        <li class="nav-item"><a class="nav-link" href="../actividades.php">Actividades</a></li>
        <li class="nav-item"><a class="nav-link" href="especialistas.php">Especialistas</a></li>
        <li class="nav-item"><a class="nav-link" href="comunidades.php">Comunidades</a></li>
        <li class="nav-item"><a class="nav-link" href="contactanos.php">Contáctanos</a></li>
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

<!-- ═══════════════════════════════ HERO ═══════════════════════════════ -->
<header class="hero">
  <h1>Un lugar para compartir lo que <span>la vida nos enseña</span></h1>
  <p>Aquí cada historia importa. Comparte tus experiencias, aprende de los demás y encuentra personas que entienden tu camino.</p>
</header>
<!-- ═══════════════════════════════ FEED ═══════════════════════════════ -->
<div class="categorias-tabs">
    <div class="categorias-tabs__inner">

        <!-- TODAS -->
        <a href="experiencias.php"
           class="categoria-tab <?= $filtro_categoria==0 ? 'active' : '' ?>">
            TODAS
        </a>

        <?php

        $categorias = mysqli_query(
            $conexion,
            "SELECT * FROM categorias_experiencias ORDER BY nombre"
        );

        $listaCategorias = [];

        while($cat = mysqli_fetch_assoc($categorias)){
            $listaCategorias[] = $cat;
        }

        // Mostrar solo las primeras 5
        for($i=0; $i<4 && $i<count($listaCategorias); $i++){

            $cat = $listaCategorias[$i];
        ?>

            <a href="experiencias.php?categoria=<?= $cat['id_categoria']?>"
               class="categoria-tab <?= $filtro_categoria==$cat['id_categoria']?'active':'' ?>">

                <?= htmlspecialchars($cat['nombre']) ?>

            </a>

        <?php } ?>


        <!-- VER MÁS -->

        <div class="dropdown">

            <button
                class="categoria-tab dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                VER MÁS

            </button>

            <ul class="dropdown-menu">

                <?php

                for($i=5; $i<count($listaCategorias); $i++){

                    $cat = $listaCategorias[$i];

                ?>

                    <li>

                        <a class="dropdown-item"
                           href="experiencias.php?categoria=<?= $cat['id_categoria']?>">

                            <?= htmlspecialchars($cat['nombre']) ?>

                        </a>

                    </li>

                <?php } ?>

            </ul>

        </div>

    </div>
</div>
<!-- ═══════════════════════════════ FORM COMPARTIR ═══════════════════════════════ -->
    <div class="compartir-card">
    <h3> Compartir experiencia</h3>
    <form action="guardar_experiencia.php" method="POST">

      <input
          type="text"
          id="nombre_autor"
          name="nombre_autor"
          placeholder="Tu nombre"
      >

      <div class="anonimo-check">
          <input
              type="checkbox"
              id="anonimo"
              name="anonimo"
              onchange="toggleAnonimo()"
          >

          <label for="anonimo">
              Publicar como Anónimo
          </label>
      </div>

    <input
      type="text"
      name="titulo"
      placeholder="¿Cuál es el título de tu historia?"
      required
    >

    <select name="id_categoria" required>
      <option value="">Elige una categoría...</option>
      <?php
        $sql_cats = "SELECT id_categoria, nombre FROM categorias_experiencias ORDER BY nombre";
        $cats     = mysqli_query($conexion, $sql_cats);
        while ($cat = mysqli_fetch_assoc($cats)):
      ?>
        <option value="<?= $cat['id_categoria'] ?>">
          <?= htmlspecialchars($cat['nombre']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <input
      type="text"
      name="ciudad"
      placeholder="Tu ciudad (opcional)"
    >

    <textarea
      name="contenido"
      rows="6"
      placeholder="Cuéntanos tu historia con tus propias palabras..."
      required
    ></textarea>

    <button type="submit"> Publicar mi experiencia</button>
  </form>
</div>

  <h2 class="titulo-seccion">Experiencias compartidas</h2>

  <?php
  // Traer experiencias con conteos de reacciones y comentarios
$sql = "
SELECT
    e.*,
    ce.nombre AS categoria_nombre,
    COALESCE(SUM(r.tipo='identifica'),0) AS cnt_identifica,
    COALESCE(SUM(r.tipo='conmueve'),0) AS cnt_conmueve,
    COALESCE(SUM(r.tipo='ayudo'),0) AS cnt_ayudo,
    (
        SELECT COUNT(*)
        FROM comentarios_experiencias c
        WHERE c.id_experiencia=e.id_experiencia
    ) AS cnt_comentarios
FROM experiencias e
LEFT JOIN categorias_experiencias ce
ON e.id_categoria=ce.id_categoria
LEFT JOIN reacciones_experiencias r
ON r.id_experiencia=e.id_experiencia
";

if($filtro_categoria>0){
    $sql.=" WHERE e.id_categoria=".$filtro_categoria;
}

$sql.="

GROUP BY e.id_experiencia

ORDER BY e.fecha_publicacion DESC";

  $resultado = mysqli_query($conexion, $sql);

  if (!$resultado) {
    echo "<p style='color:red'>Error: " . mysqli_error($conexion) . "</p>";
  } elseif (mysqli_num_rows($resultado) === 0) {
    echo "<p style='text-align:center;color:#999;padding:40px 0'>
            Aún no hay experiencias. ¡Sé el primero en compartir! 
          </p>";
  }

  $i = 0;
  while ($fila = mysqli_fetch_assoc($resultado)):
    $ini = !empty($fila['nombre_autor'])
           ? strtoupper(mb_substr($fila['nombre_autor'], 0, 1))
           : 'U';
    // Tiempo relativo
    $diff = time() - strtotime($fila['fecha_publicacion']);
    if      ($diff < 60)     $cuando = 'Hace un momento';
    elseif  ($diff < 3600)   $cuando = 'Hace ' . floor($diff/60) . ' min';
    elseif  ($diff < 86400)  $cuando = 'Hace ' . floor($diff/3600) . ' h';
    elseif  ($diff < 604800) $cuando = 'Hace ' . floor($diff/86400) . ' días';
    else                     $cuando = date('d/m/Y', strtotime($fila['fecha_publicacion']));
    $i++;
  ?>


<!-- ═══════════════════════════════ FEED ═══════════════════════════════ -->

  <!-- TARJETA -->
  <div class="card-experiencia" style="animation-delay: <?= $i * 0.07 ?>s">
    <div class="linea-azul"></div>

    <!-- HEADER -->
    <div class="header-exp">
      <div class="usuario">
        <div class="avatar"><?= $ini ?></div>
        <div>
          <h3><?= htmlspecialchars($fila['nombre_autor'] ?: 'Anónimo') ?></h3>
          <span>
            <?= $cuando ?>
            <?php if (!empty($fila['ciudad'])): ?> · <?= htmlspecialchars($fila['ciudad']) ?><?php endif; ?>
          </span>
        </div>
      </div>
      <?php if (!empty($fila['categoria_nombre'])): ?>
        <span class="etiqueta-cat"><?= htmlspecialchars($fila['categoria_nombre']) ?></span>
      <?php endif; ?>
   <div class="menu-exp">

    <button
        class="btn-menu"
        onclick="toggleMenu(<?php echo $fila['id_experiencia']; ?>)">

        <i class="bi bi-three-dots-vertical"></i>

    </button>

    <div
        class="dropdown-menu-exp"
        id="menu-<?php echo $fila['id_experiencia']; ?>">

        <?php
        if(
            isset($_SESSION["usuario_id"]) &&
            $_SESSION["usuario_id"] == $fila["id_usuario"]
        ){
        ?>

            <a
                href="eliminar_experiencia.php?id=<?php echo $fila['id_experiencia']; ?>"
                onclick="return confirm('¿Eliminar esta experiencia?')">

                 Eliminar

            </a>

        <?php }else{ ?>

            <a
                href="denunciar_experiencia.php?id=<?php echo $fila['id_experiencia']; ?>">

                 Denunciar

            </a>

        <?php } ?>

    </div>

</div>
    </div>

    <!-- CONTENIDO -->
    <h2 class="titulo"><?= htmlspecialchars($fila['titulo']) ?></h2>
    <p class="contenido"><?= nl2br(htmlspecialchars($fila['contenido'])) ?></p>

    <!-- REACCIONES  -->
    <div class="acciones">

      <?php foreach ([
        'identifica' => ['', 'Me identifica', (int)$fila['cnt_identifica']],
        'conmueve'   => ['', 'Me conmueve',   (int)$fila['cnt_conmueve']],
        'ayudo'      => ['', 'Me ayudó',      (int)$fila['cnt_ayudo']],
      ] as $tipo => [$icono, $label, $cnt]): ?>

        <button
          class="btn-reaccion"
          data-exp="<?= $fila['id_experiencia'] ?>"
          data-tipo="<?= $tipo ?>"
          onclick="reaccionar(this)"
        >
          <?= $icono ?> <?= $label ?>
          <strong class="cnt"><?= $cnt ?></strong>
        </button>

      <?php endforeach; ?>

      <button
        class="btn-comentarios"
        onclick="toggleComentarios(this, <?= $fila['id_experiencia'] ?>)"
      >
        <i class="bi bi-chat"></i>
        <span><?= (int)$fila['cnt_comentarios'] ?> comentario<?= $fila['cnt_comentarios'] != 1 ? 's' : '' ?></span>
      </button>

    </div><!-- /acciones -->

    <!-- COMENTARIOS -->
    <div class="box-comentarios" id="coms-<?= $fila['id_experiencia'] ?>">
      <div class="lista-coms" id="lista-<?= $fila['id_experiencia'] ?>">
        <!-- se carga por AJAX la primera vez -->
      </div>
      <div class="form-comentario">
        <input
          type="text"
          id="inp-com-<?= $fila['id_experiencia'] ?>"
          placeholder="Escribe tu comentario..."
          maxlength="500"
        >
        <button type="button" onclick="enviarComentario(<?= $fila['id_experiencia'] ?>)">
          Enviar
        </button>
      </div>
    </div>
    

  </div><!-- /card-experiencia -->

  <?php endwhile; ?>

</div><!-- /contenedor -->
<!-- TOAST -->
<div class="toast-msg" id="toast"></div>

<?php if ($flash): ?>
<script>
  window.addEventListener('DOMContentLoaded', () => mostrarToast(<?= json_encode($flash) ?>));
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.PARENTLY_USER = <?= json_encode($_SESSION["usuario_nombre"] ?? "Anonimo") ?>;
</script>
<script src="../experiencias.js"></script>

<script>
function toggleAnonimo(){

    const check = document.getElementById("anonimo");
    const nombre = document.getElementById("nombre_autor");

    if(check.checked){

        nombre.value = "Anónimo";
        nombre.readOnly = true;
        nombre.style.background = "#f2f2f2";

    }else{

        nombre.value = "";
        nombre.readOnly = false;
        nombre.style.background = "";
        nombre.focus();

    }

}
</script>

</body>
</html>
