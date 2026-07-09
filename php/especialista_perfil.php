<?php
session_start();
require_once "db.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$specialist = null;
$reviewMessage = "";
$reviewError = "";

$conn->query("ALTER TABLE especialistas ADD COLUMN IF NOT EXISTS lugar_graduacion VARCHAR(180) NULL AFTER descripcion");

$conn->query("CREATE TABLE IF NOT EXISTS especialista_resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    especialista_id INT NOT NULL,
    usuario_id INT NULL,
    nombre_usuario VARCHAR(100) NOT NULL,
    puntuacion TINYINT NOT NULL,
    comentario TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_resenas_especialista_fecha (especialista_id, fecha_creacion),
    INDEX idx_resenas_usuario (usuario_id),
    CONSTRAINT fk_resenas_especialista
        FOREIGN KEY (especialista_id) REFERENCES especialistas(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_resenas_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

if ($id > 0) {
    $stmt = $conn->prepare("SELECT id, nombre, apellido, especialidad, descripcion, lugar_graduacion, telefono, email, foto FROM especialistas WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $specialist = $stmt->get_result()->fetch_assoc();
}

if (!$specialist) {
    $result = $conn->query("SELECT id, nombre, apellido, especialidad, descripcion, lugar_graduacion, telefono, email, foto FROM especialistas ORDER BY id ASC LIMIT 1");
    $specialist = $result ? $result->fetch_assoc() : null;
}

if (!$specialist) {
    header("Location: especialistas.php");
    exit;
}

$specialistName = trim($specialist["nombre"] . " " . $specialist["apellido"]);
$graduationPlace = trim($specialist["lugar_graduacion"] ?? "");

$educationTitles = [
    "psicologos" => "Psicología",
    "pediatras" => "Medicina General",
    "terapeutas" => "Terapia Familiar",
    "educadores" => "Educación Inicial",
];
$educationTitle = $educationTitles[$specialist["especialidad"]] ?? $specialist["especialidad"];
$showReviewsTab = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["crear_resena"])) {
    if (!isset($_SESSION["usuario_id"], $_SESSION["usuario_nombre"])) {
        $reviewError = "Debes iniciar sesión para dejar una reseña.";
        $showReviewsTab = true;
    } else {
        $rating = isset($_POST["puntuacion"]) ? (int) $_POST["puntuacion"] : 0;
        $comment = trim($_POST["comentario"] ?? "");

        if ($rating < 1 || $rating > 5) {
            $reviewError = "Selecciona una puntuación de 1 a 5 estrellas.";
            $showReviewsTab = true;
        } elseif ($comment === "") {
            $reviewError = "Escribe tu reseña antes de publicar.";
            $showReviewsTab = true;
        } else {
            $userId = (int) $_SESSION["usuario_id"];
            $userName = $_SESSION["usuario_nombre"];
            $stmt = $conn->prepare("INSERT INTO especialista_resenas (especialista_id, usuario_id, nombre_usuario, puntuacion, comentario) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisis", $specialist["id"], $userId, $userName, $rating, $comment);

            if ($stmt->execute()) {
                header("Location: especialista_perfil.php?id=" . urlencode($specialist["id"]) . "&resena=ok#resenas");
                exit;
            }

            $reviewError = "No se pudo guardar la reseña. Intenta de nuevo.";
            $showReviewsTab = true;
        }
    }
}

if (isset($_GET["resena"]) && $_GET["resena"] === "ok") {
    $reviewMessage = "Tu reseña se publicó correctamente.";
    $showReviewsTab = true;
}

$reviews = [];
$averageRating = 0;
$stmt = $conn->prepare("
    SELECT nombre_usuario, puntuacion, comentario, fecha_creacion
    FROM especialista_resenas
    WHERE especialista_id = ?
    ORDER BY fecha_creacion DESC
");
$stmt->bind_param("i", $specialist["id"]);
$stmt->execute();
$reviewsResult = $stmt->get_result();

if ($reviewsResult) {
    $reviews = $reviewsResult->fetch_all(MYSQLI_ASSOC);
}

if (count($reviews) > 0) {
    $totalRating = array_sum(array_map(static fn($review) => (int) $review["puntuacion"], $reviews));
    $averageRating = round($totalRating / count($reviews), 1);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($specialistName); ?> - Parently</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/homepage.css">
    <link rel="stylesheet" href="../style/especialistas.css?v=rounded2026">
</head>
<body class="specialist-profile-page">

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="../index.php">
      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3" alt="Logo">
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
            <p><?php echo htmlspecialchars(ucfirst($educationTitle)); ?></p>
            <h2>Información de contacto</h2>
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
                <button class="profile-action profile-tab <?php echo !$showReviewsTab ? "active" : ""; ?>" type="button" data-profile-view="education">Información personal</button>
                <button class="profile-action profile-tab <?php echo $showReviewsTab ? "active" : ""; ?>" type="button" data-profile-view="reviews">Reseñas</button>
            </div>

            <div class="profile-info-grid">
                <article class="education-card profile-view <?php echo !$showReviewsTab ? "active" : ""; ?>" data-profile-panel="education">
                    <h2>Educación</h2>
                    <div class="education-entry">
                        <strong><?php echo htmlspecialchars(strtoupper($educationTitle)); ?></strong>
                        <p><?php echo htmlspecialchars($graduationPlace !== "" ? $graduationPlace : "Lugar de graduación no registrado"); ?></p>
                    </div>
                </article>

                <aside class="reviews-panel profile-view <?php echo $showReviewsTab ? "active" : ""; ?>" id="resenas" data-profile-panel="reviews" aria-label="Reseñas del especialista">
                    <div class="reviews-summary">
                        <div>
                            <h2>Reseñas</h2>
                            <p><?php echo count($reviews); ?> opinión<?php echo count($reviews) === 1 ? "" : "es"; ?></p>
                        </div>
                        <div class="rating-average">
                            <strong><?php echo $averageRating > 0 ? htmlspecialchars((string) $averageRating) : "0"; ?></strong>
                            <span class="stars" aria-label="<?php echo htmlspecialchars((string) $averageRating); ?> de 5 estrellas">
                                <?php for ($star = 1; $star <= 5; $star++): ?>
                                    <i class="bi <?php echo $averageRating >= $star ? "bi-star-fill" : "bi-star"; ?>"></i>
                                <?php endfor; ?>
                            </span>
                        </div>
                    </div>

                    <?php if ($reviewMessage): ?>
                        <p class="review-alert review-alert-success"><?php echo htmlspecialchars($reviewMessage); ?></p>
                    <?php endif; ?>
                    <?php if ($reviewError): ?>
                        <p class="review-alert review-alert-error"><?php echo htmlspecialchars($reviewError); ?></p>
                    <?php endif; ?>

                    <div class="reviews-list">
                        <?php if (count($reviews) > 0): ?>
                            <?php foreach ($reviews as $review): ?>
                                <article class="review-item">
                                    <div class="review-head">
                                        <strong><?php echo htmlspecialchars($review["nombre_usuario"]); ?></strong>
                                        <span><?php echo date("d/m/Y", strtotime($review["fecha_creacion"])); ?></span>
                                    </div>
                                    <div class="stars" aria-label="<?php echo (int) $review["puntuacion"]; ?> de 5 estrellas">
                                        <?php for ($star = 1; $star <= 5; $star++): ?>
                                            <i class="bi <?php echo (int) $review["puntuacion"] >= $star ? "bi-star-fill" : "bi-star"; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <p><?php echo nl2br(htmlspecialchars($review["comentario"])); ?></p>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="empty-reviews">Aún no hay reseñas. Sé la primera persona en opinar.</p>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION["usuario_id"])): ?>
                        <form class="review-form" method="POST" action="especialista_perfil.php?id=<?php echo urlencode($specialist["id"]); ?>#resenas">
                            <h3>Escribe tu reseña</h3>
                            <fieldset class="rating-field">
                                <legend>Puntuación</legend>
                                <?php for ($star = 5; $star >= 1; $star--): ?>
                                    <input type="radio" id="rating-<?php echo $star; ?>" name="puntuacion" value="<?php echo $star; ?>" required>
                                    <label for="rating-<?php echo $star; ?>" aria-label="<?php echo $star; ?> estrellas"><i class="bi bi-star-fill"></i></label>
                                <?php endfor; ?>
                            </fieldset>
                            <textarea name="comentario" rows="4" maxlength="600" placeholder="Comparte tu experiencia con este especialista" required></textarea>
                            <button type="submit" name="crear_resena">Publicar reseña</button>
                        </form>
                    <?php else: ?>
                        <div class="review-login-box">
                            <p>Inicia sesión para dejar tu reseña y puntuar con estrellas.</p>
                            <a href="login.php">Iniciar sesión</a>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>
        </section>
    </section>
</main>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-logo">
      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="Logo Parently">
    </div>
    <div class="footer-content">
      <h2>Contáctanos:</h2>
      <div class="footer-links">
        <div class="footer-column">
          <p>
            <a href="https://www.instagram.com/parently_team?igsh=d251dXlzcnF4anp5" class="footer-link">
              <i class="bi bi-instagram"></i> @parently_team
            </a>
          </p>
          <p>
            <a href="https://whatsapp.com/channel/0029VbD4Q1CEawdpYOZHis1g" class="footer-link">
              <i class="bi bi-whatsapp"></i> Canal de WhatsApp
            </a>
          </p>
        </div>
        <div class="footer-column">
          <p>
            <a href="mailto:tucorreo@gmail.com" class="footer-link">
              <i class="bi bi-envelope"></i> parently@gmail.com
            </a>
          </p>
          <p>
            <a href="https://www.facebook.com/share/g/1CgdV2AhZ4/" class="footer-link">
              <i class="bi bi-facebook"></i> Comunidad Facebook
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
const profileTabs = document.querySelectorAll('[data-profile-view]');
const profilePanels = document.querySelectorAll('[data-profile-panel]');

function showProfilePanel(panelName) {
    profileTabs.forEach((tab) => {
        tab.classList.toggle('active', tab.dataset.profileView === panelName);
    });

    profilePanels.forEach((panel) => {
        panel.classList.toggle('active', panel.dataset.profilePanel === panelName);
    });
}

profileTabs.forEach((tab) => {
    tab.addEventListener('click', () => {
        showProfilePanel(tab.dataset.profileView);
    });
});

if (window.location.hash === '#resenas' || new URLSearchParams(window.location.search).has('resena')) {
    showProfilePanel('reviews');
}
</script>
</body>
</html>