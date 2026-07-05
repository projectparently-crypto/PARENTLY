<?php
session_start();
header("Content-Type: application/json");

include "db.php";

$foro = $_GET["foro_id"] ?? 0;

$sql = "

SELECT

c.*,

u.nombre_usuario,

u.foto_perfil

FROM comentarios c

LEFT JOIN usuarios u
ON c.usuario_id = u.id

WHERE c.foro_id = ?

ORDER BY c.fecha ASC

";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $foro);
$stmt->execute();

$res = $stmt->get_result();

$comentarios = [];

while($fila = $res->fetch_assoc()){

    if($fila["anonimo"] == 1){
        $fila["es_mio"] = (
    isset($_SESSION["usuario_id"]) &&
    $_SESSION["usuario_id"] == $fila["usuario_id"]
);
        $fila["nombre_usuario"] = "Anónimo";
        $fila["foto_perfil"] = "";

    }else{

        if(empty($fila["foto_perfil"])){
            $fila["foto_perfil"] = "default.png";
        }

    }

    $comentarios[] = $fila;
}

echo json_encode($comentarios);