<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];

$conn->query("
UPDATE comentarios
SET likes = likes + 1
WHERE id='$id'
");

echo json_encode([
  "ok"=>true
]);

?>