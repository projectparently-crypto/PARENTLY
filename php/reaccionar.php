<?php

include("conexion.php");

$id_experiencia = $_POST['id_experiencia'];
$tipo = $_POST['tipo'];

$sql = "INSERT INTO reacciones_experiencias
(id_experiencia, tipo)
VALUES
('$id_experiencia','$tipo')";

mysqli_query($conexion,$sql);

header("Location: comunidades.php");

exit();
?>