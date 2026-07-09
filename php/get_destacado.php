<?php
header("Content-Type: application/json; charset=utf-8");
include "db.php";

$foro_id = $_GET["foro_id"] ?? 0;

$stmt = $conn->prepare("
    SELECT 
        u.id,
        u.nombre_usuario,
        u.foto_perfil,
        COUNT(c.id) AS total_comentarios
    FROM comentarios c
    INNER JOIN usuarios u ON u.id = c.usuario_id
    WHERE c.foro_id = ?
    GROUP BY u.id, u.nombre_usuario, u.foto_perfil
    ORDER BY total_comentarios DESC
    LIMIT 1
");

$stmt->bind_param("i", $foro_id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode($row ?? null);