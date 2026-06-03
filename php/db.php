<?php

$conn = new mysqli("localhost","root","","db_parently");

if ($conn->connect_error) {
  die("Error DB");
}

?>
