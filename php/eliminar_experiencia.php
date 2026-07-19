<?php
session_start();
include("conexion.php");

// Verificar sesión
if (!isset($_SESSION["usuario_id"])) {
    die("Debes iniciar sesión.");
}

// Verificar que llegue el id
if (!isset($_GET["id"])) {
    die("Experiencia no válida.");
}

$id = (int)$_GET["id"];
$id_usuario = $_SESSION["usuario_id"];

// Verificar que la experiencia exista y pertenezca al usuario
$sql = "SELECT id_usuario
        FROM experienciasform
        WHERE id_experiencia = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error: " . $conexion->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("La experiencia no existe.");
}

$fila = $resultado->fetch_assoc();

// Verificar propietario
if ($fila["id_usuario"] != $id_usuario) {
    die("No tienes permiso para eliminar esta experiencia.");
}

// Eliminar comentarios
$stmt = $conexion->prepare("
    DELETE FROM comentarios_experiencias
    WHERE id_experiencia = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();

// Eliminar reacciones
$stmt = $conexion->prepare("
    DELETE FROM reacciones_experiencias
    WHERE id_experiencia = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();

// Eliminar la experiencia
$stmt = $conexion->prepare("
    DELETE FROM experienciasform
    WHERE id_experiencia = ?
");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    $_SESSION["flash"] = "🗑️ Experiencia eliminada correctamente.";

} else {

    $_SESSION["flash"] = "❌ No se pudo eliminar la experiencia.";

}

$stmt->close();
$conexion->close();

header("Location: experiencias.php");
exit;
?>