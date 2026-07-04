<?php

header("Content-Type: application/json; charset=utf-8");
include "db.php";

$foro_id = $_GET["foro_id"] ?? 0;

$stmt = $conn->prepare("
SELECT
    u.id AS usuario_id,
    u.nombre_usuario,
    u.foto_perfil,
    MIN(p.fecha_union) AS fecha_union
FROM participantes p
INNER JOIN usuarios u
    ON p.usuario_id = u.id
WHERE p.foro_id = ?
GROUP BY u.id, u.nombre_usuario, u.foto_perfil
ORDER BY fecha_union ASC
");

$stmt->bind_param("i", $foro_id);
$stmt->execute();

$result = $stmt->get_result();

$miembros = [];

while($row = $result->fetch_assoc()){
    $miembros[] = $row;
}

echo json_encode($miembros);