<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$comentario_id = $data["comentario_id"];
$usuario = $data["usuario"];
$texto = $data["texto"];

$conn->query("
INSERT INTO respuestas(comentario_id,usuario,texto)
VALUES('$comentario_id','$usuario','$texto')
");

echo json_encode([
  "ok"=>true
]);

?>