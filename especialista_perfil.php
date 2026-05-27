<?php session_start(); ?>
<?php
$specialists = [
    "alexander" => [
        "name" => "Alexander Benjamin Peraza Soto",
        "title" => "Psicologo enfocado en crianza positiva",
        "area" => "Psicologia infantil",
        "photo" => "https://randomuser.me/api/portraits/men/32.jpg",
        "phone" => "760305712",
        "email" => "alexander.peraza@parently.com",
        "education" => "Licenciatura en Psicologia - Universidad de El Salvador"
    ],
    "mariana" => [
        "name" => "Mariana Yanin Hernandez Mejia",
        "title" => "Profesional relacionada con la salud",
        "area" => "Medicina General",
        "photo" => "https://randomuser.me/api/portraits/women/44.jpg",
        "phone" => "783065712",
        "email" => "digital.factura06@gmail.com",
        "education" => "Hospital General del Instituto Salvadoreño del Seguro Social 1990"
    ],
    "julio" => [
        "name" => "Julio Armando Parrales Aguilar",
        "title" => "Terapeuta familiar y emocional",
        "area" => "Terapia familiar",
        "photo" => "https://randomuser.me/api/portraits/men/75.jpg",
        "phone" => "712345609",
        "email" => "julio.parrales@parently.com",
        "education" => "Maestria en Terapia Familiar - Universidad Centroamericana"
    ],
    "marianna" => [
        "name" => "Marianna Yanin Hernandez Mejia",
        "title" => "Educadora especializada en primera infancia",
        "area" => "Educacion inicial",
        "photo" => "https://randomuser.me/api/portraits/women/65.jpg",
        "phone" => "706543219",
        "email" => "marianna.hernandez@parently.com",
        "education" => "Licenciatura en Educacion Inicial - Universidad Pedagogica"
    ],
    "josue" => [
        "name" => "Josue Sebastian Rodriguez Ayala",
        "title" => "Psicologo de desarrollo infantil",
        "area" => "Psicologia infantil",
        "photo" => "https://randomuser.me/api/portraits/men/46.jpg",
        "phone" => "745612378",
        "email" => "josue.rodriguez@parently.com",
        "education" => "Especializacion en Desarrollo Infantil - Universidad Evangelica"
    ],
    "sofia" => [
        "name" => "Sofia Victoria Fernandez Mira",
        "title" => "Pediatra dedicada al bienestar infantil",
        "area" => "Pediatria",
        "photo" => "https://randomuser.me/api/portraits/women/68.jpg",
        "phone" => "790456123",
        "email" => "sofia.fernandez@parently.com",
        "education" => "Doctorado en Medicina - Universidad de El Salvador"
    ]
];

$id = $_GET["id"] ?? "mariana";
$specialist = $specialists[$id] ?? $specialists["mariana"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($specialist["name"]); ?> - Parently</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="especialistas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="specialist-profile-page">
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3" alt="Parently">
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
                <li class="nav-item"><a class="nav-link" href="#">Comunidades</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contactanos</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="profile-shell">
    <header class="profile-brand">
        <img src="photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
        <span>Parently</span>
    </header>

    <section class="specialist-profile-layout">
        <article class="profile-contact-card">
            <img class="profile-photo" src="<?php echo htmlspecialchars($specialist["photo"]); ?>" alt="<?php echo htmlspecialchars($specialist["name"]); ?>">
            <h1><?php echo htmlspecialchars($specialist["name"]); ?></h1>
            <p class="profile-title"><?php echo htmlspecialchars($specialist["title"]); ?></p>
            <h2>Especialidad</h2>
            <p><?php echo htmlspecialchars($specialist["area"]); ?></p>
            <h2>Informacion de contacto</h2>
            <a href="https://wa.me/503<?php echo htmlspecialchars($specialist["phone"]); ?>">
                <i class="bi bi-whatsapp"></i>
                <?php echo htmlspecialchars($specialist["phone"]); ?>
            </a>
            <a href="mailto:<?php echo htmlspecialchars($specialist["email"]); ?>">
                <i class="bi bi-envelope"></i>
                <?php echo htmlspecialchars($specialist["email"]); ?>
            </a>
        </article>

        <section class="profile-main-info">
            <div class="profile-actions">
                <a href="especialistas.php" class="profile-action">Regresar</a>
                <a href="mailto:<?php echo htmlspecialchars($specialist["email"]); ?>" class="profile-action">Reservar</a>
            </div>
            <article class="education-card">
                <h2>Educacion</h2>
                <strong><?php echo htmlspecialchars(strtoupper($specialist["area"])); ?></strong>
                <p><?php echo htmlspecialchars($specialist["education"]); ?></p>
            </article>
        </section>
    </section>
</main>

<footer class="specialist-footer">
    <img src="photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="">
    <strong>Parently</strong>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
