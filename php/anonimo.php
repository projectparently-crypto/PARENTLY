<?php
session_start();
include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"] ?? 0;

$sql = "UPDATE comentarios SET anonimo = IF(anonimo=1,0,1) WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

echo json_encode(["ok" => true]);
?>