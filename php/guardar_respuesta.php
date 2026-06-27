<?php

include("conexion.php");

if(isset($_POST['respuesta'])){

    $id_pregunta = $_POST['id_pregunta'];
    $respuesta = $_POST['respuesta'];

    $sql = "INSERT INTO respuestasc
            (id_pregunta, respuesta)
            VALUES (?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param(
        "is",
        $id_pregunta,
        $respuesta
    );

    $stmt->execute();

}

header("Location: comunidades.php");
exit();

?>