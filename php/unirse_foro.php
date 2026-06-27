<?php
header("Content-Type: application/json; charset=utf-8");
session_start();
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$foro_id = $data["foro_id"] ?? null;
$usuario_id = $_SESSION["usuario_id"] ?? null;

if(!$foro_id || !$usuario_id){
  echo json_encode([
    "success" => false,
    "error" => "datos_faltantes"
  ]);
  exit;
}

/* =========================
   VER SI YA ESTÁ INSCRITO
========================= */
$check = $conn->prepare("SELECT id FROM participantes WHERE foro_id = ? AND usuario_id = ?");
$check->bind_param("ii", $foro_id, $usuario_id);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){

  // YA ESTÁ → SALIR (BORRAR)
  $del = $conn->prepare("DELETE FROM participantes WHERE foro_id = ? AND usuario_id = ?");
  $del->bind_param("ii", $foro_id, $usuario_id);
  $del->execute();

  echo json_encode([
    "success" => true,
    "estado" => "salio"
  ]);
  exit;
}

/* =========================
   SI NO ESTÁ → UNIRSE
========================= */
$stmt = $conn->prepare("INSERT INTO participantes (foro_id, usuario_id) VALUES (?, ?)");
$stmt->bind_param("ii", $foro_id, $usuario_id);

$ok = $stmt->execute();

/* contar total */
$count = $conn->prepare("SELECT COUNT(*) as total FROM participantes WHERE foro_id = ?");
$count->bind_param("i", $foro_id);
$count->execute();
$total = $count->get_result()->fetch_assoc()["total"];

echo json_encode([
  "success" => $ok,
  "estado" => "unido",
  "ahora" => (int)$total
]);