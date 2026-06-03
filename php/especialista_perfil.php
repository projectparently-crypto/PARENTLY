<?php
session_start();
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$specialist = null;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT id, nombre, apellido, especialidad, descripcion, telefono, email, foto FROM especialistas WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $specialist = $stmt->get_result()->fetch_assoc();
}

if (!$specialist) {
    $result = $conn->query("SELECT id, nombre, apellido, especialidad, descripcion, telefono, email, foto FROM especialistas ORDER BY id ASC LIMIT 1");
    $specialist = $result ? $result->fetch_assoc() : null;
}

if (!$specialist) {
    header("Location: especialistas.php");
    exit;
}

$specialistName = trim($specialist["nombre"] . " " . $specialist["apellido"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($specialistName); ?> - Parently</title>
    <link rel="stylesheet" href="../style/homepage.css">
    <link rel="stylesheet" href="../style/especialistas.css">

    <title><?php echo htmlspecialchars($specialist["name"]); ?> - Parently</title>
    <link rel="stylesheet" href="../style/homepage.css">
    <link rel="stylesheet" href="../style/especialistas.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="specialist-profile-page">
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
                <li class="nav-item"><a class="nav-link" href="#">Actividades</a></li>
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

<main class="profile-shell">
    <header class="profile-brand">
        <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
        <span>Parently</span>
    </header>

    <section class="specialist-profile-layout">
        <article class="profile-contact-card">
            <img class="profile-photo" src="<?php echo htmlspecialchars($specialist["foto"] ?? ""); ?>" alt="<?php echo htmlspecialchars($specialistName); ?>">
            <h1><?php echo htmlspecialchars($specialistName); ?></h1>
            <p class="profile-title"><?php echo htmlspecialchars($specialist["descripcion"] ?? ""); ?></p>
            <h2>Especialidad</h2>
            <p><?php echo htmlspecialchars($specialist["especialidad"]); ?></p>
            <h2>Informacion de contacto</h2>
            <a href="https://wa.me/503<?php echo htmlspecialchars($specialist["telefono"] ?? ""); ?>">
                <i class="bi bi-whatsapp"></i>
                <?php echo htmlspecialchars($specialist["telefono"] ?? ""); ?>
            </a>
            <a href="mailto:<?php echo htmlspecialchars($specialist["email"] ?? ""); ?>">
                <i class="bi bi-envelope"></i>
                <?php echo htmlspecialchars($specialist["email"] ?? ""); ?>
            </a>
        </article>

        <section class="profile-main-info">
            <div class="profile-actions">
                <a href="especialistas.php" class="profile-action">Regresar</a>
                <a href="" class="profile-action">Reseñas</a>
            </div>
            <article class="education-card">
                <h2>Descripcion</h2>
                <strong><?php echo htmlspecialchars(strtoupper($specialist["especialidad"])); ?></strong>
                <p><?php echo htmlspecialchars($specialist["descripcion"] ?? ""); ?></p>
            </article>
        </section>
    </section>
</main>

<footer class="specialist-footer">
    <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
    <strong>Parently</strong>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
