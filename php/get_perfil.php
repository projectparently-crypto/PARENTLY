<?php
header("Content-Type: application/json; charset=utf-8");
include "db.php";

$usuario_id = $_GET["id"] ?? 0;
$foro_id = $_GET["foro_id"] ?? 0;

// INFO DEL USUARIO
$stmt = $conn->prepare("
    SELECT id, nombre_usuario, bio, foto_perfil, fecha_registro
    FROM usuarios
    WHERE id = ?
");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo json_encode(null);
    exit;
}

// FORO ACTUAL (si existe participación)
$stmt2 = $conn->prepare("
    SELECT fecha_union
    FROM participantes
    WHERE usuario_id = ? AND foro_id = ?
");
$stmt2->bind_param("ii", $usuario_id, $foro_id);
$stmt2->execute();
$part = $stmt2->get_result()->fetch_assoc();

// CONTADORES
$stmt3 = $conn->prepare("
    SELECT COUNT(*) as total
    FROM participantes
    WHERE usuario_id = ?
");
$stmt3->bind_param("i", $usuario_id);
$stmt3->execute();
$foros = $stmt3->get_result()->fetch_assoc()["total"];

$stmt4 = $conn->prepare("
    SELECT COUNT(*) as total
    FROM comentarios
    WHERE usuario_id = ?
");
$stmt4->bind_param("i", $usuario_id);
$stmt4->execute();
$comentarios = $stmt4->get_result()->fetch_assoc()["total"];

echo json_encode([
    "id" => $user["id"],
    "nombre_usuario" => $user["nombre_usuario"],
    "bio" => $user["bio"],
    "foto_perfil" => $user["foto_perfil"],
    "fecha_registro" => $user["fecha_registro"],

    "foros" => $foros,
    "comentarios" => $comentarios,

    "fecha_union" => $part["fecha_union"] ?? null
]);