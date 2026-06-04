<?php
session_start();
include 'db.php';

// Obtener todas las guías
function getGuias($limit = null) {
    global $conn;
    $query = "SELECT * FROM guias WHERE activo = 1 ORDER BY fecha_creacion DESC";
    if ($limit) {
        $query .= " LIMIT $limit";
    }
    return $conn->query($query);
}

// Obtener guías por categoría
function getGuiasPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT * FROM guias WHERE categoria = '$categoria' AND activo = 1 ORDER BY fecha_creacion DESC";
    return $conn->query($query);
}

// Obtener guías por etapa
function getGuiasPorEtapa($etapa) {
    global $conn;
    $etapa = $conn->real_escape_string($etapa);
    $query = "SELECT * FROM guias WHERE etapa = '$etapa' AND activo = 1 ORDER BY fecha_creacion DESC";
    return $conn->query($query);
}

// Obtener guías por tipo
function getGuiasPorTipo($tipo) {
    global $conn;
    $tipo = $conn->real_escape_string($tipo);
    $query = "SELECT * FROM guias WHERE tipo_guia = '$tipo' AND activo = 1 ORDER BY fecha_creacion DESC";
    return $conn->query($query);
}

// Obtener una guía específica
function getGuiaById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM guias WHERE id = $id AND activo = 1";
    return $conn->query($query)->fetch_assoc();
}

// Obtener guías ordenadas aleatoriamente
function getGuiasAleatorias($limit = 4) {
    global $conn;
    $query = "SELECT * FROM guias WHERE activo = 1 ORDER BY RAND() LIMIT $limit";
    return $conn->query($query);
}

// Obtener categorías únicas
function getCategorias() {
    global $conn;
    $query = "SELECT DISTINCT categoria FROM guias WHERE activo = 1 ORDER BY categoria";
    return $conn->query($query);
}

// Contar guías por categoría
function contarPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT COUNT(*) as total FROM guias WHERE categoria = '$categoria' AND activo = 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Obtener guías destacadas
function getGuiasDestacadas($limit = 4) {
    global $conn;
    $query = "SELECT * FROM guias WHERE activo = 1 LIMIT $limit";
    return $conn->query($query);
}
?>
