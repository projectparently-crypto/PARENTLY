<?php
session_start();
header("Content-Type: application/json");

include "db.php";

if (!isset($_SESSION["usuario_id"])) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Debes iniciar sesión."
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$comentario_id = intval($data["id"] ?? 0);
$motivo = trim($data["motivo"] ?? "");
$foro_id = intval($data["foro_id"] ?? 0);
$usuario_id = $_SESSION["usuario_id"];

if ($comentario_id <= 0 || $foro_id <= 0 || $motivo == "") {
    echo json_encode([
        "success" => false,
        "mensaje" => "Datos incompletos."
    ]);
    exit;
}

/* Verificar que el comentario exista */

$stmt = $conn->prepare("SELECT id FROM comentarios WHERE id = ?");
$stmt->bind_param("i", $comentario_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Comentario no encontrado."
    ]);
    exit;
}

/* Evitar reportes duplicados */

$stmt = $conn->prepare("
    SELECT id
    FROM reportes
    WHERE comentario_id = ?
    AND usuario_id = ?
");

$stmt->bind_param("ii", $comentario_id, $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {

    echo json_encode([
        "success" => false,
        "mensaje" => "Ya reportaste este comentario."
    ]);

    exit;
}

/* Guardar reporte */

$stmt = $conn->prepare("
    INSERT INTO reportes
    (comentario_id, usuario_id, foro_id, motivo)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param(
    "iiis",
    $comentario_id,
    $usuario_id,
    $foro_id,
    $motivo
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false,
        "mensaje" => "Error al guardar el reporte."
    ]);

}