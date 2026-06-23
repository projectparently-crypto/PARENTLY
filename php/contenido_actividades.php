<?php

include("conexion.php");
include("../contenido_actividades.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM descripcion_actividades WHERE id = $id";

$resultado = mysqli_query($conexion, $sql);

if(!$resultado){
    die("Error en la consulta: " . mysqli_error($conexion));
}

$actividad = mysqli_fetch_assoc($resultado);

if(!$actividad){
    die("Actividad no encontrada");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <link rel="stylesheet" href="../style/contenido_actividades.css">
    
<body>

</body>
</html>
