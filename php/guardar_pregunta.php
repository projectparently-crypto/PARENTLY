<?php

include("conexion.php");
include("comunidad_schema.php");

asegurar_comunidad_schema($conexion);

if(isset($_POST['pregunta'])){

    $pregunta = $_POST['pregunta'];
    $id_usuario = usuario_actual_id() ?: null;

    $sql = "INSERT INTO preguntasc(id_usuario, pregunta)
            VALUES (?, ?)";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("is", $id_usuario, $pregunta);

    $stmt->execute();

}

header("Location: preguntas.php");
exit();

?>
