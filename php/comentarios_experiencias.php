<?php

header('Content-Type: application/json; charset=utf-8');
include("conexion.php");


// ============================================
// OBTENER COMENTARIOS (GET)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id_experiencia = (int)($_GET['id_experiencia'] ?? 0);

    if ($id_experiencia <= 0) {
        echo json_encode([
            "ok" => false,
            "error" => "ID inválido"
        ]);
        exit;
    }

    $stmt = mysqli_prepare(
        $conexion,
        "SELECT
            nombre_usuario,
            comentario,
            DATE_FORMAT(fecha_comentario,'%d/%m/%Y %H:%i') AS fecha
         FROM comentarios_experiencias
         WHERE id_experiencia = ?
         ORDER BY fecha_comentario ASC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id_experiencia
    );

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    echo json_encode([
        "ok" => true,
        "comentarios" => mysqli_fetch_all($res, MYSQLI_ASSOC)
    ]);

    exit;
}


// ============================================
// GUARDAR COMENTARIO (POST)
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

    if (str_contains($contentType, 'application/json')) {

        $data = json_decode(file_get_contents("php://input"), true);

    } else {

        $data = $_POST;

    }

    $id_experiencia = (int)($data['id_experiencia'] ?? 0);

    $nombre_usuario = trim(
        strip_tags($data['nombre_usuario'] ?? 'Anónimo')
    );

    $comentario = trim(
        strip_tags($data['comentario'] ?? '')
    );

    if ($id_experiencia <= 0 || strlen($comentario) < 2) {

        echo json_encode([
            "ok" => false,
            "error" => "Datos incompletos."
        ]);

        exit;
    }

    if ($nombre_usuario == "") {
        $nombre_usuario = "Anónimo";
    }

    $stmt = mysqli_prepare(

        $conexion,

        "INSERT INTO comentarios_experiencias
        (id_experiencia,nombre_usuario,comentario)
        VALUES (?,?,?)"

    );

    mysqli_stmt_bind_param(

        $stmt,

        "iss",

        $id_experiencia,

        $nombre_usuario,

        $comentario

    );

    if (mysqli_stmt_execute($stmt)) {

        echo json_encode([

            "ok" => true,

            "nombre_usuario" => $nombre_usuario,

            "comentario" => $comentario,

            "fecha" => date("d/m/Y H:i")

        ]);

    } else {

        echo json_encode([

            "ok" => false,

            "error" => mysqli_error($conexion)

        ]);

    }

    exit;

}

// ============================================
// MÉTODO NO VÁLIDO
// ============================================

echo json_encode([

    "ok" => false,

    "error" => "Método no soportado"

]);