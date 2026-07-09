<?php

include("conexion.php");

$edad = isset($_GET['edad']) ? $_GET['edad'] : '0-3';

$sql = "SELECT * FROM contenido_actividades
        WHERE edad = '$edad'
        ORDER BY id ASC";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>