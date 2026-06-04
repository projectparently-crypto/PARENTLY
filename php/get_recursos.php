<?php

include 'db.php'; // Tu conexión a la base de datos

// Obtener recursos más vistos
function getRecursosMasVistos($limit = 2) {
    global $conn;
    $query = "SELECT * FROM recursos WHERE activo = 1 ORDER BY fecha_creacion DESC LIMIT $limit";
    return $conn->query($query);
}

// Obtener consejos del día
function getConsejos($limit = 4) {
    global $conn;
    $query = "SELECT * FROM recursos WHERE tipo = 'articulo' AND activo = 1 LIMIT $limit";
    return $conn->query($query);
}

// Obtener etapas
function getEtapas() {
    global $conn;
    $query = "SELECT * FROM etapas ORDER BY nombre";
    return $conn->query($query);
}

// Obtener guías
function getGuias($limit = 4) {
    global $conn;
    $query = "SELECT * FROM recursos WHERE tipo = 'guia' AND activo = 1 LIMIT $limit";
    return $conn->query($query);
}

// Obtener recursos por categoría
function getRecursosPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT * FROM recursos WHERE categoria = '$categoria' AND activo = 1";
    return $conn->query($query);
}

// Obtener un recurso específico
function getRecursoById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM recursos WHERE id = $id AND activo = 1";
    return $conn->query($query)->fetch_assoc();
}
?>