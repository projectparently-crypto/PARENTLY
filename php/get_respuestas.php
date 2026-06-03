<?php

include "db.php";

$id = $_GET["id"];

$result = $conn->query("
SELECT * FROM respuestas
WHERE comentario_id='$id'
ORDER BY id DESC
");

$respuestas = [];

while($row = $result->fetch_assoc()){

  $respuestas[] = $row;

}

echo json_encode($respuestas);

?>