<?php
session_start();

include("php/conexion.php");

$edad = isset($_GET['edad']) ? $_GET['edad'] : '0-3';

$sql = "SELECT * FROM contenido_actividades
        WHERE edad = '$edad'
        ORDER BY id ASC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="style/actividades.css">
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
                    <a class="nav-link" href="php/recursos.php">Recursos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="actividades.php">Actividades</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="php/especialistas.php">Especialistas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="php/comunidades.php">Comunidades</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="php/contactanos.php">Contactanos</a>
                </li>

            </ul>

            <div class="d-flex gap-2 align-items-center">

                <?php if (isset($_SESSION["usuario_nombre"])): ?>

                    <div class="profile-btn d-flex align-items-center gap-2">

                        <a href="php/perfil.php" class="avatar-link">
                            <div class="avatar-small">
                                <?php echo strtoupper(substr($_SESSION["usuario_nombre"],0,1)); ?>
                            </div>
                        </a>

                        <a href="php/perfil.php" class="profile-name">
                            <?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?>
                        </a>

                        <a href="php/logout.php" class="btn btn-danger btn-sm">
                            Cerrar Sesión
                        </a>

                    </div>

                <?php else: ?>

                    <a href="php/login.php" class="btn btn-outline-success">
                        Iniciar Sesión
                    </a>

                    <a href="php/registro.php" class="btn btn-success">
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
<?php
$edad = isset($_GET['edad']) ? $_GET['edad'] : '0-3';
?>

<div class="edades">

<a href="?edad=0-3">
    <button class="edad-btn <?=($edad=="0-3")?"active":""?>">
        0-3 años
    </button>
</a>

<a href="?edad=4-6">
    <button class="edad-btn <?=($edad=="4-6")?"active":""?>">
        4-6 años
    </button>
</a>

<a href="?edad=7-9">
    <button class="edad-btn <?=($edad=="7-9")?"active":""?>">
        7-9 años
    </button>
</a>

<a href="?edad=9-12">
    <button class="edad-btn <?=($edad=="9-12")?"active":""?>">
        9-12 años
    </button>
</a>

<a href="?edad=13-18">
    <button class="edad-btn <?=($edad=="13-18")?"active":""?>">
        13-18 años
    </button>
</a>

</div>

<!-- CARDS DINAMICAS -->

<section class="contenedor-cards">

<?php while($actividad = mysqli_fetch_assoc($resultado)): ?>

    <div class="card">

        <img
            src="/parently/photos/<?php echo htmlspecialchars($actividad['imagen']); ?>"
            alt="<?php echo htmlspecialchars($actividad['nombre_actividad']); ?>"
        >

        <div class="card-content">

            <h3>
                <?php echo htmlspecialchars($actividad['nombre_actividad']); ?>
            </h3>

            <a href="actividades1.php?categoria=<?php echo urlencode($actividad['nombre_actividad']); ?>">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>