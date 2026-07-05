<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include("conexion.php");
include("comunidad_schema.php");

asegurar_comunidad_schema($conexion);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Metodo no permitido']);
    exit;
}

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (str_contains($contentType, 'application/json')) {
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
} else {
    $data = $_POST;
}

$idPregunta = (int)($data['id_pregunta'] ?? 0);
$tipo = $data['tipo'] ?? '';
$tiposOk = ['interesa', 'ayuda'];
$idUsuario = usuario_actual_id();

if ($idPregunta <= 0 || !in_array($tipo, $tiposOk, true)) {
    echo json_encode(['ok' => false, 'error' => 'Datos invalidos']);
    exit;
}

if ($idUsuario <= 0) {
    echo json_encode(['ok' => false, 'error' => 'Inicia sesion para reaccionar']);
    exit;
}

$stmt = mysqli_prepare(
    $conexion,
    "SELECT id_reaccion FROM reacciones_preguntas
     WHERE id_pregunta = ? AND id_usuario = ? AND tipo = ?"
);
mysqli_stmt_bind_param($stmt, 'iis', $idPregunta, $idUsuario, $tipo);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$existe = mysqli_stmt_num_rows($stmt) > 0;

if ($existe) {
    $stmtDel = mysqli_prepare(
        $conexion,
        "DELETE FROM reacciones_preguntas
         WHERE id_pregunta = ? AND id_usuario = ? AND tipo = ?"
    );
    mysqli_stmt_bind_param($stmtDel, 'iis', $idPregunta, $idUsuario, $tipo);
    mysqli_stmt_execute($stmtDel);
    $activa = false;
} else {
    $stmtIns = mysqli_prepare(
        $conexion,
        "INSERT INTO reacciones_preguntas (id_pregunta, id_usuario, tipo)
         VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmtIns, 'iis', $idPregunta, $idUsuario, $tipo);
    mysqli_stmt_execute($stmtIns);
    $activa = true;
}

$conteos = ['interesa' => 0, 'ayuda' => 0];
$res = mysqli_query(
    $conexion,
    "SELECT tipo, COUNT(*) AS total
     FROM reacciones_preguntas
     WHERE id_pregunta = $idPregunta
     GROUP BY tipo"
);

while ($row = mysqli_fetch_assoc($res)) {
    $conteos[$row['tipo']] = (int)$row['total'];
}

echo json_encode([
    'ok' => true,
    'activa' => $activa,
    'tipo' => $tipo,
    'conteos' => $conteos,
]);
