<?php

date_default_timezone_set('America/El_Salvador');

$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_parently"
);

if (!$conexion) {
    die("Error de conexión");
}

mysqli_set_charset($conexion, "utf8");

mysqli_query($conexion, "SET time_zone = '-06:00'");
?>