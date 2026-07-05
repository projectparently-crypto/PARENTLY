<?php
session_start();
// reaccionar.php — llamado por fetch() desde experiencias.js
// Devuelve JSON, NO redirige
header('Content-Type: application/json; charset=utf-8');
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

// Soporta JSON y form-data
$ct = $_SERVER['CONTENT_TYPE'] ?? '';
if (str_contains($ct, 'application/json')) {
    $data = json_decode(file_get_contents('php://input'), true) ?? [];
} else {
    $data = $_POST;
}

$id_experiencia = (int)($data['id_experiencia'] ?? 0);
$tipo           = $data['tipo'] ?? '';
// Usamos id_usuario = 0 para usuarios invitados (igual que tu BD tiene ya)
$id_usuario     = (int)($_SESSION['usuario_id'] ?? $_SESSION['id_usuario'] ?? $_SESSION['id'] ?? 0);

$tipos_ok = ['identifica', 'conmueve', 'ayudo'];
if (!$id_experiencia || !in_array($tipo, $tipos_ok)) {
    echo json_encode(['ok' => false, 'error' => 'Datos inválidos']);
    exit;
}

// ¿Ya existe esta reacción?
$chk = mysqli_prepare($conexion,
    "SELECT id_reaccion FROM reacciones_experiencias
     WHERE id_experiencia = ? AND id_usuario = ? AND tipo = ?"
);
mysqli_stmt_bind_param($chk, 'iis', $id_experiencia, $id_usuario, $tipo);
mysqli_stmt_execute($chk);
mysqli_stmt_store_result($chk);
$existe = mysqli_stmt_num_rows($chk) > 0;

if ($existe) {
    // Quitar reacción (toggle off)
    $del = mysqli_prepare($conexion,
        "DELETE FROM reacciones_experiencias
         WHERE id_experiencia = ? AND id_usuario = ? AND tipo = ?"
    );
    mysqli_stmt_bind_param($del, 'iis', $id_experiencia, $id_usuario, $tipo);
    mysqli_stmt_execute($del);
    $activa = false;
} else {
    // Agregar reacción
    $ins = mysqli_prepare($conexion,
        "INSERT INTO reacciones_experiencias (id_experiencia, id_usuario, tipo)
         VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param($ins, 'iis', $id_experiencia, $id_usuario, $tipo);
    mysqli_stmt_execute($ins);
    $activa = true;
}

// Conteos actuales
$conteos = ['identifica' => 0, 'conmueve' => 0, 'ayudo' => 0];
$res = mysqli_query($conexion,
    "SELECT tipo, COUNT(*) AS total
     FROM reacciones_experiencias
     WHERE id_experiencia = $id_experiencia
     GROUP BY tipo"
);
while ($row = mysqli_fetch_assoc($res)) {
    $conteos[$row['tipo']] = (int)$row['total'];
}

echo json_encode([
    'ok'     => true,
    'activa' => $activa,
    'tipo'   => $tipo,
    'conteos'=> $conteos,
]);
