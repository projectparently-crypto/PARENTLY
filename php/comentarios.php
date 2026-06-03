<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$foro_id = $data["foro_id"];
$comentario = $data["comentario"];
$usuario = $data["usuario"];

/* INSERTAR */
$sql = "INSERT INTO comentarios(foro_id, usuario, texto)
VALUES('$foro_id','$usuario','$comentario')";

$conn->query($sql);

echo json_encode([
  "ok" => true
]);

?>