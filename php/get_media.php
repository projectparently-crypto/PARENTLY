<?php
session_start();
header("Content-Type: application/json");

include "db.php";

$foro = $_GET["foro_id"] ?? 0;

$sql = "
SELECT
    c.id,
    c.usuario_id,
    c.texto,
    c.imagenes,
    c.fecha,
    c.anonimo,
    u.nombre_usuario,
    u.foto_perfil
FROM comentarios c
LEFT JOIN usuarios u
ON c.usuario_id = u.id
WHERE c.foro_id = ?
AND c.imagenes IS NOT NULL
AND c.imagenes <> ''
ORDER BY c.fecha DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $foro);
$stmt->execute();

$res = $stmt->get_result();

$media = [];
$usuarioActual = $_SESSION["usuario_id"] ?? 0;

while($fila = $res->fetch_assoc()){

    $fila["anonimo"] = (int)$fila["anonimo"];

    $fila["es_mio"] = ($fila["usuario_id"] == $usuarioActual);

    // 🔥 ANONIMATO BIEN HECHO
    if($fila["anonimo"] == 1){
        $fila["nombre_usuario"] = "Anónimo";
        $fila["foto_perfil"] = "default.png";
    } else {
        $fila["foto_perfil"] = !empty($fila["foto_perfil"])
            ? $fila["foto_perfil"]
            : "default.png";
    }

    $media[] = $fila;
}

echo json_encode($media);