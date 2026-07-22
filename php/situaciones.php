<?php

session_start();

include("conexion.php");
include("comunidad_schema.php");

$sql="SELECT *

FROM situaciones

ORDER BY fecha_publicacion DESC";

$situaciones=mysqli_query($conexion,$sql);

?>