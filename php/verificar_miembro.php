<?php
header("Content-Type: application/json; charset=utf-8");

session_start();
include "db.php";

$foro_id = $_GET["foro_id"] ?? 0;
$usuario_id = $_SESSION["usuario_id"] ?? 0;

if (!$foro_id || !$usuario_id) {
  echo json_encode([
    "unido" => false,
    "ahora" => 0
  ]);
  exit;
}

/* =========================
   VER SI EL USUARIO ESTÁ UNIDO
========================= */
$stmt = $conn->prepare("
  SELECT id 
  FROM participantes 
  WHERE foro_id = ? AND usuario_id = ?
");

$stmt->bind_param("ii", $foro_id, $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

$unido = ($res->num_rows > 0);

/* =========================
   CONTAR MIEMBROS DEL FORO
========================= */
$stmt2 = $conn->prepare("
  SELECT COUNT(*) as total 
  FROM participantes 
  WHERE foro_id = ?
");

$stmt2->bind_param("i", $foro_id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row = $result2->fetch_assoc();

$total = $row["total"] ?? 0;

/* =========================
   RESPUESTA FINAL
========================= */
echo json_encode([
  "unido" => $unido,
  "ahora" => $total
]);
?>