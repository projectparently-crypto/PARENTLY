<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];

$sql = "DELETE FROM comentarios WHERE id='$id'";

$conn->query($sql);

echo json_encode([
  "ok" => true
]);

?>