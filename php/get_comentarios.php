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

    $usuarioActual = $_SESSION["usuario_id"] ?? 0;

    // 👇 SIEMPRE calcular esto
    $fila["es_mio"] = ($usuarioActual == $fila["usuario_id"]);

    if($fila["anonimo"] == 1){
        $fila["nombre_usuario"] = "Anónimo";
        $fila["foto_perfil"] = "";
    } else {
        if(empty($fila["foto_perfil"])){
            $fila["foto_perfil"] = "default.png";
        }
    }
    if(empty($fila["imagenes"])){
    $fila["imagenes"] = "";
}
    $comentarios[] = $fila;
}

echo json_encode($comentarios);