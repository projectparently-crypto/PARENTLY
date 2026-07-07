<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["usuario_id"])) {
    die("Debes iniciar sesión.");
}

if (!isset($_GET["id"])) {
    die("Experiencia no válida.");
}

$id = (int)$_GET["id"];
$id_usuario = $_SESSION["usuario_id"];

// Verificar que la experiencia pertenece al usuario
$sql = "SELECT id_usuario FROM experiencias WHERE id_experiencia = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("La experiencia no existe.");
}

$fila = $resultado->fetch_assoc();

if ($fila["id_usuario"] != $id_usuario) {
    die("No tienes permiso para eliminar esta experiencia.");
}

// Eliminar comentarios primero (si existen)
$stmt = $conexion->prepare("DELETE FROM comentarios_experiencias WHERE id_experiencia=?");
$stmt->bind_param("i",$id);
$stmt->execute();

// Eliminar reacciones
$stmt = $conexion->prepare("DELETE FROM reacciones_experiencias WHERE id_experiencia=?");
$stmt->bind_param("i",$id);
$stmt->execute();

// Eliminar experiencia
$stmt = $conexion->prepare("DELETE FROM experiencias WHERE id_experiencia=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$_SESSION["flash"] = "Experiencia eliminada correctamente.";

header("Location: experiencias.php");
exit;