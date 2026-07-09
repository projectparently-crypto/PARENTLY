<?php 

include("conexion.php");

$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$nombre = mysqli_real_escape_string($conexion, $nombre);

$sql = "SELECT * FROM descripcion_actividades
        WHERE nombre_activity = '$nombre'";

$resultado = mysqli_query($conexion, $sql);

if(!$resultado){
    die("Error en la consulta: " . mysqli_error($conexion));
}

$actividad = mysqli_fetch_assoc($resultado);

if(!$actividad){
    die("Actividad no encontrada");
}
?>


