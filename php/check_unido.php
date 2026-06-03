<?php

session_start();

include "db.php";

$foro = $_GET["foro_id"];

$usuario = $_SESSION["usuario_nombre"];

$result = $conn->query("
SELECT * FROM participantes
WHERE foro_id=$foro
AND usuario='$usuario'
");

echo json_encode([
  "unido" => $result->num_rows > 0
]);

?>