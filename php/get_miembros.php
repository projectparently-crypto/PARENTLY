<?php
header("Content-Type: application/json; charset=utf-8");
ini_set('display_errors', 0);
error_reporting(0);

include "db.php"; // 👈 ESTE ES EL IMPORTANTE

$foro_id = $_GET["foro_id"] ?? 0;

if (!$foro_id) {
  echo json_encode(["total" => 0]);
  exit;
}

$stmt = $conn->prepare("
  SELECT COUNT(*) AS total
  FROM participantes
  WHERE foro_id = ?
");

$stmt->bind_param("i", $foro_id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
  "total" => $row["total"] ?? 0
]);