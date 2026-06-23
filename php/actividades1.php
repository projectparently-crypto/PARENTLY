<?php

include("conexion.php");
include("../actividades1.php");

$sql = "SELECT * FROM actividades ORDER BY id ASC";

$resultado = mysqli_query($conexion, $sql);

if(!$resultado){
    die("Error en la consulta: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <link rel="stylesheet" href="../style/actividades.css">
    
<body>
</body>
</html>