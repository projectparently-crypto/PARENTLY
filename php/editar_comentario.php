<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];
$texto = $data["texto"];

$stmt = $conn->prepare("UPDATE comentarios SET texto=? WHERE id=?");
$stmt->bind_param("si", $texto, $id);

$stmt->execute();

echo json_encode(["ok"=>true]);