<?php

include "db.php";

$foro = $_GET["foro_id"];

$result = $conn->query("SELECT * FROM comentarios WHERE foro_id=$foro ORDER BY id DESC");

$data = [];

while($row = $result->fetch_assoc()){
  $data[] = $row;
}

echo json_encode($data);

?>