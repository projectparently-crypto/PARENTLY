<?php
header("Content-Type: application/json");
include "db.php";

$id = $_GET["id"] ?? 0;
$foro_id = $_GET["foro_id"] ?? 0;

if (!$id || !$foro_id) {
  echo json_encode(["error" => "faltan datos"]);
  exit;
}

$sql = "
SELECT 
    u.id,
    u.nombre_usuario,
    u.bio,
    u.foto_perfil,
    u.fecha_registro
FROM usuarios u
INNER JOIN participantes p ON p.usuario_id = u.id
WHERE u.id = ? AND p.foro_id = ?
LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $foro_id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
  echo json_encode(["error" => "Perfil vacío o no encontrado"]);
  exit;
}

echo json_encode($data);