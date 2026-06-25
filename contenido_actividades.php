<?php
session_start();
include("php/conexion.php");


$sql = "SELECT * FROM descripcion_actividades ORDER BY id ASC";
$resultado = mysqli_query($conexion, $sql);
$actividad = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($actividad['nombre_activity']); ?>
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/contenido_actividades.css">

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
                    <a class="nav-link" href="../php/recursos.php">Recursos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../php/actividades.php">Actividades</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../php/especialistas.php">Especialistas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../php/comunidades.php">Comunidades</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../php/contactanos.php">Contactanos</a>
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


<!-- CONTENIDO -->

<section class="actividad-container">

    <h1 class="titulo">
        <?php echo htmlspecialchars($actividad['nombre_activity']); ?>
    </h1>

    <div class="imagen-principal">

        <img
            src="/PARENTLY/photos/<?php echo htmlspecialchars($actividad['image']); ?>"
            alt="<?php echo htmlspecialchars($actividad['nombre_activity']); ?>"
        >

    </div>

    <div class="contenido-principal">

        <!-- COLUMNA IZQUIERDA -->

        <div class="columna-izquierda">

            <div class="materiales">

                <h2>Materiales</h2>

                <p>
                    <?php echo nl2br(htmlspecialchars($actividad['materiales'])); ?>
                </p>

            </div>

            <div class="imagen-descriptiva">

                <img
                    src="/parently/photos/<?php echo htmlspecialchars($actividad['descriptive_image']); ?>"
                    alt="Imagen descriptiva"
                >

            </div>

        </div>

        <!-- COLUMNA DERECHA -->

        <div class="columna-derecha">

            <div class="pasos">

                <h2>Paso a paso</h2>

                <p>
                    <?php echo nl2br(htmlspecialchars($actividad['pasos'])); ?>
                </p>

            </div>

            <div class="dato-curioso">

                <h2>Dato curioso</h2>

                <p>
                    <?php echo htmlspecialchars($actividad['fun_fact']); ?>
                </p>

            </div>

        </div>

    </div>

</section>

<!-- FOOTER -->

<footer class="specialist-footer">

    <img src="/parently/photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png">

    <strong>Parently</strong>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>|