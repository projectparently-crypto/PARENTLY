<?php
session_start();
header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","db_parently");

$data = json_decode(file_get_contents("php://input"), true);

$comentario_id = $data["comentario_id"];
$usuario_id = $_SESSION["usuario_id"];

// ver si ya dio like
$check = $conn->query("
  SELECT * FROM likes
  WHERE comentario_id=$comentario_id AND usuario_id=$usuario_id
");

if ($check->num_rows > 0) {

    // quitar like
    $conn->query("
      DELETE FROM likes
      WHERE comentario_id=$comentario_id AND usuario_id=$usuario_id
    ");

    $liked = false;

} else {

    // dar like
    $conn->query("
      INSERT INTO likes (comentario_id, usuario_id)
      VALUES ($comentario_id, $usuario_id)
    ");

    $liked = true;
}

// contar likes
$count = $conn->query("
  SELECT COUNT(*) as total
  FROM likes
  WHERE comentario_id=$comentario_id
")->fetch_assoc();

echo json_encode([
  "liked" => $liked,
  "likes" => $count["total"]
]);