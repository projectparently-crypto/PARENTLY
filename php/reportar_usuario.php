<?php

session_start();
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$usuario_id = $data["usuario_id"] ?? 0;
$foro_id = $data["foro_id"] ?? 0;
$motivo = trim($data["motivo"] ?? "");
$reportado_por = $_SESSION["usuario_id"] ?? 0;

if(!$usuario_id || !$foro_id || !$motivo){
  echo json_encode([
    "success" => false,
    "mensaje" => "Datos incompletos"
  ]);
  exit;
}

$stmt = $conn->prepare("
  INSERT INTO reportes_usuarios
  (usuario_id, foro_id, reportado_por, motivo, fecha)
  VALUES (?, ?, ?, ?, NOW())
");

$stmt->bind_param("iiis", $usuario_id, $foro_id, $reportado_por, $motivo);

if($stmt->execute()){
  echo json_encode(["success" => true]);
}else{
  echo json_encode([
    "success" => false,
    "mensaje" => "Error al reportar"
  ]);
}