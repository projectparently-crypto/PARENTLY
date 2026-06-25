<?php
// guardar_experiencia.php
session_start();
include("conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: experiencias.php");
    exit;
}

// Leer y limpiar datos
$nombre_autor = trim(strip_tags($_POST['nombre_autor'] ?? ''));
$titulo       = trim(strip_tags($_POST['titulo']       ?? ''));
$id_categoria = (int)($_POST['id_categoria']           ?? 0);
$ciudad       = trim(strip_tags($_POST['ciudad']       ?? ''));
$contenido    = trim(strip_tags($_POST['contenido']    ?? ''));
$id_usuario   = $_SESSION['id'] ?? null;   // si tienes sesión de usuario

// Validar mínimos
if (!$titulo || !$contenido || $id_categoria < 1) {
    $_SESSION['flash'] = '⚠️ Por favor completa todos los campos obligatorios.';
    header("Location: experiencias.php");
    exit;
}

if (!$nombre_autor) $nombre_autor = 'Anónimo';

// Insertar en la tabla principal 'experiencias'
$stmt = mysqli_prepare($conexion,
    "INSERT INTO experiencias (id_categoria, nombre_autor, titulo, contenido, ciudad)
     VALUES (?, ?, ?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, 'issss',
    $id_categoria, $nombre_autor, $titulo, $contenido, $ciudad
);

if (mysqli_stmt_execute($stmt)) {
    // También guardar en experienciasform (tabla auxiliar)
    $nuevo_id = mysqli_insert_id($conexion);
    $stmt2 = mysqli_prepare($conexion,
        "INSERT INTO experienciasform (id_experiencia, id_usuario, id_categoria, titulo, contenido)
         VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt2, 'iiiss',
        $nuevo_id, $id_usuario, $id_categoria, $titulo, $contenido
    );
    mysqli_stmt_execute($stmt2);

    $_SESSION['flash'] = '🌟 ¡Tu experiencia fue publicada! Gracias por compartir.';
} else {
    $_SESSION['flash'] = '❌ Hubo un error al guardar. Intenta de nuevo.';
}

mysqli_stmt_close($stmt);
header("Location: experiencias.php");
exit;
