<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$foro = $data["foro_id"];
$usuario = $data["usuario"];
$texto = $data["comentario"];

$conn->query("
INSERT INTO comentarios (foro_id, usuario, texto)
VALUES ($foro,'$usuario','$texto')
");

echo "ok";

?>