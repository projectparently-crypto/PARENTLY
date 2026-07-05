<?php
session_start();
include("php/conexion.php");

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$categoria = mysqli_real_escape_string($conexion, $categoria);

$sql = "SELECT * FROM actividades
        WHERE categoria = '$categoria'
        ORDER BY id ASC";

$resultado = mysqli_query($conexion, $sql);

if(!$resultado){
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actividades</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
   <link rel="stylesheet" href="style/actividades1.css">
</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">

        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="/parently/photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">
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
                                <?php echo strtoupper(substr($_SESSION["usuario_nombre"],0,1)); ?>
                            </div>
                        </a>

                        <a href="perfil.php" class="profile-name">
                            <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?>
                        </a>

                        <a href="logout.php" class="btn btn-danger btn-sm">
                            Cerrar Sesión
                        </a>

                    </div>

                <?php else: ?>

                    <a href="login.php" class="btn btn-outline-success">
                        Iniciar Sesión
                    </a>

                    <a href="registro.php" class="btn btn-success">
                        Registrarse
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>
</nav>

<!-- HERO -->

<section class="hero">

    <div class="hero-text">

        <h1>CONECTAR, JUGAR Y APRENDER JUNTOS</h1>

        <p>
            Descubre ideas para disfrutar de tiempo en familia,
            estimular el desarrollo de tus hijos y fortalecer
            el vínculo parental.
        </p>

    </div>

</section>

<!-- TITULO -->

<h1 class="titulo">Actividades</h1>

<!-- BOTONES -->
<a href="actividades.php" class="btn btn-success">
    ← Volver a categorías
</a>

<!-- CARDS DINAMICAS -->

<section class="contenedor-cards">

<?php while($actividad = mysqli_fetch_assoc($resultado)): ?>

    <div class="card">

        <img
            src="/parently/photos/<?php echo htmlspecialchars($actividad['image']); ?>"
            alt="<?php echo htmlspecialchars($actividad['activity_name']); ?>"
        >

        <div class="card-content">

            <h3>
                <?php echo htmlspecialchars($actividad['activity_name']); ?>
            </h3>

           <a href="contenido_actividades.php?id=<?php echo $actividad['id']; ?>">
                <button type="button">Ver más</button>
            </a>
        </div>

    </div>

<?php endwhile; ?>

</section>

<!-- FOOTER -->

<footer class="specialist-footer">

    <img src="/parently/photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png">

    <strong>Parently</strong>

</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>