<?php

include("conexion.php");

if(isset($_POST['pregunta'])){

    $pregunta = $_POST['pregunta'];

    $sql = "INSERT INTO preguntasc(pregunta)
            VALUES (?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("s", $pregunta);

    $stmt->execute();

}

header("Location: comunidad.php");
exit();

?>