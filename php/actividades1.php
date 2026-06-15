<?php

include("conexion.php");

$sql = "SELECT * FROM actividades ORDER BY id ASC";

$resultado = mysqli_query($conexion, $sql);

if(!$resultado){
    die("Error en la consulta: " . mysqli_error($conexion));
}

?>