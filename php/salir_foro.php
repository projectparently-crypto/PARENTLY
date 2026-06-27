<?php
header("Content-Type: application/json; charset=utf-8");

session_start();
include "db.php";

$input = json_decode(file_get_contents("php://input"), true);

$foro_id = $input["foro_id"] ?? 0;
$usuario_id = $_SESSION["usuario_id"] ?? 0;

if (!$foro_id || !$usuario_id) {
  echo json_encode(["success" => false]);
  exit;
}

/* BORRAR PARTICIPANTE */
$stmt = $conn->prepare("
  DELETE FROM participantes 
  WHERE foro_id = ? AND usuario_id = ?
");

$stmt->bind_param("ii", $foro_id, $usuario_id);
$ok = $stmt->execute();

/* CONTAR MIEMBROS ACTUALIZADOS */
$stmt2 = $conn->prepare("
  SELECT COUNT(*) as total 
  FROM participantes 
  WHERE foro_id = ?
");

$stmt2->bind_param("i", $foro_id);
$stmt2->execute();
$total = $stmt2->get_result()->fetch_assoc()["total"];

echo json_encode([
  "success" => $ok,
  "ahora" => $total
]);
?>