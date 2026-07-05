<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

include "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$foro = $data["foro_id"] ?? 0;
$texto = trim($data["comentario"] ?? "");
$parent = (int)($data["parent_id"] ?? 0);
$anonimo = $data["anonimo"] ?? 0;

if(!isset($_SESSION["usuario_id"])){
    echo json_encode([
        "ok"=>false,
        "mensaje"=>"Debes iniciar sesión."
    ]);
    exit;
}

if($texto == ""){
    echo json_encode([
        "ok"=>false
    ]);
    exit;
}

$usuario = $_SESSION["usuario_id"];

$sql = "INSERT INTO comentarios
(foro_id,usuario_id,texto,parent_id,anonimo)
VALUES(?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisii", $foro, $usuario, $texto, $parent, $anonimo);
$stmt->execute();

$id = $conn->insert_id;

/* obtener usuario */
$sql = "SELECT nombre_usuario, foto_perfil
        FROM usuarios
        WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario);
$stmt->execute();

$res = $stmt->get_result();
$user = $res->fetch_assoc();

echo json_encode([
    "ok" => true,
    "id" => $id,
    "texto" => $texto,
    "fecha" => date("Y-m-d H:i:s"),
    "likes" => 0,
    "anonimo" => $anonimo,
    "nombre_usuario" => $anonimo ? "Anónimo" : $user["nombre_usuario"],
    "foto_perfil" => $anonimo ? "" : $user["foto_perfil"]
]);

exit;