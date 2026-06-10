<?php
$conexion = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_parently"
);

if(!$conexion){
    die("Error de conexión");
}
?>