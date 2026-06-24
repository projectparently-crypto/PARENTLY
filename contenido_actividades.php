<?php
session_start();

include("php/conexion.php");

$sql = "SELECT * FROM descripcion_actividades ORDER BY id ASC";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($actividad['nombre_activity']); ?></title>

    <link rel="stylesheet" href="style/contenido_actividades.css">
</head>

<body>

<section class="actividad-container">

    <div class="actividad-header">

        <div class="actividad-texto">

            <h1>
                <?php echo htmlspecialchars($actividad['nombre_activity']); ?>
            </h1>

            <div class="materiales">

                <h2>Materiales</h2>

                <p>
                    <?php echo nl2br(htmlspecialchars($actividad['materiales'])); ?>
                </p>

            </div>

        </div>

        <div class="actividad-imagen">

            <img
                src="photos/<?php echo htmlspecialchars($actividad['image']); ?>"
                alt="<?php echo htmlspecialchars($actividad['nombre_activity']); ?>"
            >

        </div>

    </div>

    <div class="pasos-section">

        <h2>Paso a paso</h2>

        <p>
            <?php echo nl2br(htmlspecialchars($actividad['pasos'])); ?>
        </p>

    </div>

    <div class="fun-fact">

        <h2>Dato Curioso</h2>

        <p>
            <?php echo htmlspecialchars($actividad['fun_fact']); ?>
        </p>

    </div>

    <div class="descripcion-imagen">

        <img
            src="/parently/photos/<?php echo htmlspecialchars($actividad['descriptive_image']); ?>"
            alt="Imagen descriptiva"
        >

    </div>

</section>

</body>
</html>