<?php

include("conexion.php");

$sql = "SELECT * FROM contenido_actividades ORDER BY id ASC";

$resultado = mysqli_query($conexion, $sql);

if(!$resultado){
    die("Error en la consulta: " . mysqli_error($conexion));
}

?>