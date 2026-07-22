<?php
session_start();
include("conexion.php");

// Verificar método
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: experiencias.php");
    exit;
}

// Verificar sesión
if (!isset($_SESSION["usuario_id"])) {
    $_SESSION["flash"] = "Debes iniciar sesión para publicar una experiencia.";
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION["usuario_id"];

$nombre_autor = trim($_POST["nombre_autor"] ?? "");
$titulo = trim($_POST["titulo"] ?? "");
$id_categoria = (int)($_POST["id_categoria"] ?? 0);
$ciudad = trim($_POST["ciudad"] ?? "");
$contenido = trim($_POST["contenido"] ?? "");

// Si publicó como anónimo
if (isset($_POST["anonimo"])) {
    $nombre_autor = "Anónimo";
}

// Validaciones
if (
    empty($nombre_autor) ||
    empty($titulo) ||
    empty($contenido) ||
    $id_categoria <= 0
) {
    $_SESSION["flash"] = "Completa todos los campos obligatorios.";
    header("Location: experiencias.php");
    exit;
}

// Consulta
$sql = "INSERT INTO experienciasform
(
    id_usuario,
    id_categoria,
    nombre_autor,
    titulo,
    contenido,
    ciudad
)
VALUES
(
    ?, ?, ?, ?, ?, ?
)";

$stmt = mysqli_prepare($conexion, $sql);

if (!$stmt) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

mysqli_stmt_bind_param(
    $stmt,
    "iissss",
    $id_usuario,
    $id_categoria,
    $nombre_autor,
    $titulo,
    $contenido,
    $ciudad
);

if (mysqli_stmt_execute($stmt)) {

    $_SESSION["flash"] = "🎉 Tu experiencia fue publicada correctamente.";

} else {

    die("Error al guardar: " . mysqli_error($conexion));

}

mysqli_stmt_close($stmt);
mysqli_close($conexion);

header("Location: experiencias.php");
exit;
?>