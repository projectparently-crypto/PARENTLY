<?php
session_start();

include("conexion.php");
include("comunidad_schema.php");

asegurar_comunidad_schema($conexion);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: preguntas.php");
    exit;
}

$idPregunta = (int)($_POST['id_pregunta'] ?? 0);
$accion = $_POST['accion'] ?? '';
$idUsuario = usuario_actual_id();
$esAdmin = usuario_es_admin();

if ($idPregunta <= 0) {
    header("Location: preguntas.php");
    exit;
}

$stmt = mysqli_prepare($conexion, "SELECT id_usuario FROM preguntasc WHERE id_pregunta = ?");
mysqli_stmt_bind_param($stmt, 'i', $idPregunta);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$pregunta = mysqli_fetch_assoc($res);

if (!$pregunta) {
    header("Location: preguntas.php");
    exit;
}

$autorId = (int)($pregunta['id_usuario'] ?? 0);
$puedeModificar = $esAdmin || ($idUsuario > 0 && $autorId === $idUsuario);

if ($accion === 'editar' && $puedeModificar) {
    $texto = trim(strip_tags($_POST['pregunta'] ?? ''));

    if ($texto !== '') {
        $stmtEdit = mysqli_prepare(
            $conexion,
            "UPDATE preguntasc SET pregunta = ?, editado = 1 WHERE id_pregunta = ?"
        );
        mysqli_stmt_bind_param($stmtEdit, 'si', $texto, $idPregunta);
        mysqli_stmt_execute($stmtEdit);
    }
} elseif ($accion === 'eliminar' && $puedeModificar) {
    $stmtRes = mysqli_prepare($conexion, "DELETE FROM respuestasc WHERE id_pregunta = ?");
    mysqli_stmt_bind_param($stmtRes, 'i', $idPregunta);
    mysqli_stmt_execute($stmtRes);

    $stmtReac = mysqli_prepare($conexion, "DELETE FROM reacciones_preguntas WHERE id_pregunta = ?");
    mysqli_stmt_bind_param($stmtReac, 'i', $idPregunta);
    mysqli_stmt_execute($stmtReac);

    $stmtDen = mysqli_prepare($conexion, "DELETE FROM denuncias_preguntas WHERE id_pregunta = ?");
    mysqli_stmt_bind_param($stmtDen, 'i', $idPregunta);
    mysqli_stmt_execute($stmtDen);

    $stmtDel = mysqli_prepare($conexion, "DELETE FROM preguntasc WHERE id_pregunta = ?");
    mysqli_stmt_bind_param($stmtDel, 'i', $idPregunta);
    mysqli_stmt_execute($stmtDel);
} elseif ($accion === 'denunciar') {
    $motivo = trim(strip_tags($_POST['motivo'] ?? 'Contenido reportado'));
    if ($motivo === '') {
        $motivo = 'Contenido reportado';
    }

    $usuarioNullable = $idUsuario > 0 ? $idUsuario : null;
    $stmtDenuncia = mysqli_prepare(
        $conexion,
        "INSERT INTO denuncias_preguntas (id_pregunta, id_usuario, motivo)
         VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmtDenuncia, 'iis', $idPregunta, $usuarioNullable, $motivo);
    mysqli_stmt_execute($stmtDenuncia);
}

header("Location: preguntas.php");
exit;
