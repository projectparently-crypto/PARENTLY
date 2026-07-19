<?php

include("conexion.php");

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$categoria = mysqli_real_escape_string($conexion, $categoria);

$sql = "SELECT * FROM actividades
        WHERE categoria = '$categoria'
        ORDER BY id ASC";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>