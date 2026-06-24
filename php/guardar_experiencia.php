<?php

include("conexion.php");

$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];
$id_categoria = $_POST['id_categoria'];

$sql = "INSERT INTO experiencias
(
id_categoria,
titulo,
contenido
)
VALUES
(
'$id_categoria',
'$titulo',
'$contenido'
)";

mysqli_query($conexion,$sql);

header("Location: experiencias.php");
exit();