<?php
session_start();
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"]);
$usuario = $_SESSION["usuario_id"] ?? 0;

// Verificar que el comentario pertenezca al usuario
$stmt = $conn->prepare("
    SELECT usuario_id
    FROM comentarios
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows == 0){
    echo json_encode([
        "ok" => false,
        "mensaje" => "Comentario no encontrado."
    ]);
    exit;
}

$comentario = $res->fetch_assoc();

if($comentario["usuario_id"] != $usuario){
    echo json_encode([
        "ok" => false,
        "mensaje" => "No tienes permiso para eliminar este comentario."
    ]);
    exit;
}

// Eliminar solo si es suyo
$stmt = $conn->prepare("
    DELETE FROM comentarios
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode([
    "ok" => true
]);