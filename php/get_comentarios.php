<?php

include "db.php";

$foro = $_GET["foro_id"];

$sql = "SELECT * FROM comentarios
WHERE foro_id='$foro'
ORDER BY id DESC";

$result = $conn->query($sql);

$comentarios = [];

while($row = $result->fetch_assoc()){

  $comentarios[] = $row;

}

echo json_encode($comentarios);

?>