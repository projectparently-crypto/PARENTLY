<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$foro = $data["foro_id"];
$usuario = $data["usuario"];

$conn->query("INSERT INTO participantes (foro_id, usuario) VALUES ($foro,'$usuario')");

$conn->query("UPDATE foros SET miembros = miembros + 1 WHERE id=$foro");

echo "ok";

?>