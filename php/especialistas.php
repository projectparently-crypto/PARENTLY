<?php
session_start();
require_once "db.php";

$specialists = [];
$result = $conn->query("SELECT id, nombre, apellido, especialidad, descripcion, telefono, email, foto FROM especialistas ORDER BY id ASC");

if ($result) {
    $specialists = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Especialistas - Parently</title>
    <link rel="stylesheet" href="style/homepage.css">
    <link rel="stylesheet" href="style/especialistas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="specialists-page">
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3" alt="Parently">
            Parently
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mx-auto gap-2">
                <li class="nav-item"><a class="nav-link" href="recursos.php">Recursos</a></li>
                <li class="nav-item"><a class="nav-link" href="actividades.php">Actividades</a></li>
                <li class="nav-item"><a class="nav-link active" href="especialistas.php">Especialistas</a></li>
                <li class="nav-item"><a class="nav-link" href="comunidades.php">Comunidades</a></li>
                <li class="nav-item"><a class="nav-link" href="contactanos.php">Contactanos</a></li>
            </ul>

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
    </div>
</nav>

<main class="specialists-shell">
    <section class="specialists-hero">
        <div class="specialists-hero-copy">
            <p>La mejor crianza</p>
            <h1>Con los mejores especialistas</h1>
        </div>
        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1100&q=80" alt="Equipo de especialistas de salud">
    </section>

    <section class="specialty-filters" aria-label="Filtrar especialistas">
        <button class="specialty-filter active" type="button" data-filter="all">
            <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
            <span>Todos</span>
        </button>
        <button class="specialty-filter" type="button" data-filter="psicologos">
            <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
            <span>Psicologos</span>
        </button>
        <button class="specialty-filter" type="button" data-filter="pediatras">
            <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
            <span>Pediatras</span>
        </button>
        <button class="specialty-filter" type="button" data-filter="terapeutas">
            <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
            <span>Terapeutas</span>
        </button>
        <button class="specialty-filter" type="button" data-filter="educadores">
            <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
            <span>Educadores</span>
        </button>
    </section>

    <section class="specialists-grid" id="specialistsGrid">
        <?php foreach ($specialists as $specialist): ?>
            <article class="specialist-card" data-area="<?php echo htmlspecialchars($specialist["especialidad"]); ?>">
                <img class="specialist-photo" src="<?php echo htmlspecialchars($specialist["foto"]); ?>" alt="<?php echo htmlspecialchars($specialist["nombre"] . " " . $specialist["apellido"]); ?>">
                <h2><?php echo htmlspecialchars($specialist["nombre"]); ?></h2>
                <p><?php echo htmlspecialchars($specialist["apellido"]); ?></p>
                <div class="specialist-icons">
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-envelope"></i>
                </div>
                <a href="especialista_perfil.php?id=<?php echo urlencode($specialist["id"]); ?>">Ver perfil</a>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<footer class="specialist-footer">
    <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
    <strong>Parently</strong>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const filterButtons = document.querySelectorAll('.specialty-filter');
const cards = document.querySelectorAll('.specialist-card');

filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const filter = button.dataset.filter;

        filterButtons.forEach((item) => item.classList.remove('active'));
        button.classList.add('active');

        cards.forEach((card) => {
            const shouldShow = filter === 'all' || card.dataset.area === filter;
            card.classList.toggle('is-hidden', !shouldShow);
        });
    });
});
</script>
</body>
</html>
