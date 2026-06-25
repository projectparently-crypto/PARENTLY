<?php

header("Content-Type: application/json");
include "conexion.php";
error_reporting(0);

$foro_id = $_GET["foro_id"] ?? 1;

$sql = "SELECT u.nombre_usuario, p.fecha_union
        FROM participantes p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        WHERE p.foro_id = ?
        ORDER BY p.fecha_union ASC
        LIMIT 1";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "error" => true,
        "data" => null
    ]);
    exit;
}

$stmt->bind_param("i", $foro_id);
$stmt->execute();

$resultado = $stmt->get_result();
$data = $resultado->fetch_assoc() ?: null;

echo json_encode([
    "error" => false,
    "data" => $data
]);

exit;