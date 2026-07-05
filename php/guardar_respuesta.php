<?php

include("conexion.php");

if(isset($_POST['respuesta'])){

    $id_pregunta = (int)$_POST['id_pregunta'];
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

$redirect = $_POST['redirect'] ?? 'comunidades.php';
$permitidos = ['comunidades.php', 'preguntas.php'];

if (!in_array($redirect, $permitidos, true)) {
    $redirect = 'comunidades.php';
}

header("Location: " . $redirect);
exit();

?>
