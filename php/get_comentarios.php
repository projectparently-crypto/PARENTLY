<?php

header("Content-Type: application/json");
include "db.php";
error_reporting(0);

$foro = $_GET["foro_id"] ?? 0;

$sql = "SELECT * FROM comentarios WHERE foro_id = ? ORDER BY id DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "error" => true,
        "data" => []
    ]);
    exit;
}

$stmt->bind_param("i", $foro);
$stmt->execute();

$result = $stmt->get_result();

$comentarios = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $comentarios[] = $row;
    }
}

echo json_encode($comentarios ?: []);

exit;