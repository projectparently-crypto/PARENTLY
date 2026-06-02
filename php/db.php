<?php

$conn = new mysqli("localhost","root","","parently");

if ($conn->connect_error) {
  die("Error DB");
}

?>