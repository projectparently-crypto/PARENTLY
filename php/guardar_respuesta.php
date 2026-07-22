<?php
session_start();

include("conexion.php");
include("comunidad_schema.php");

asegurar_comunidad_schema($conexion);

header("Content-Type: application/json");

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Debes iniciar sesión para responder."
    ]);
    exit();
}

$id_usuario = $_SESSION["usuario_id"];

// Verificar que llegaron los datos
if (!isset($_POST["id_situacion"]) || !isset($_POST["id_opcion"])) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Datos incompletos."
    ]);
    exit();
}

$id_situacion = intval($_POST["id_situacion"]);
$id_opcion = intval($_POST["id_opcion"]);

// Verificar si ya respondió esa situación
$sql = "SELECT id_respuesta
        FROM respuestas_situacion
        WHERE id_usuario = ?
        AND id_situacion = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_usuario, $id_situacion);
$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows > 0){

    echo json_encode([
        "success" => false,
        "mensaje" => "Ya respondiste esta situación."
    ]);

    exit();
}

// Guardar respuesta

$sql = "INSERT INTO respuestas_situacion
(id_usuario,id_situacion,id_opcion)
VALUES(?,?,?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "iii",
    $id_usuario,
    $id_situacion,
    $id_opcion
);

if($stmt->execute()){

    // Obtener la información de la opción elegida
    $consulta = $conexion->prepare("
        SELECT texto, explicacion, es_recomendada
        FROM opciones_situacion
        WHERE id_opcion = ?
    ");

    $consulta->bind_param("i", $id_opcion);
    $consulta->execute();

    $resultado = $consulta->get_result();
    $opcion = $resultado->fetch_assoc();

    echo json_encode([
        "success" => true,
        "texto" => $opcion["texto"],
        "explicacion" => $opcion["explicacion"],
        "recomendada" => $opcion["es_recomendada"]
    ]);

}else{

    echo json_encode([
        "success"=>false,
        "mensaje"=>"No se pudo guardar la respuesta."
    ]);



    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo guardar la respuesta."
    ]);

}
?>