<?php
include 'db.php';

// Obtener todos los consejos de la tabla consejos
function getConsejosDelDia($limit = null) {
    global $conn;
    $query = "SELECT * FROM consejos WHERE activo = 1 ORDER BY fecha_creacion DESC";
    if ($limit) {
        $limit = intval($limit);
        $query .= " LIMIT $limit";
    }
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener consejos por categoría
function getConsejosPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT * FROM consejos WHERE categoria = '$categoria' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener consejos por etapa
function getConsejosPorEtapa($etapa) {
    global $conn;
    $etapa = $conn->real_escape_string($etapa);
    $query = "SELECT * FROM consejos WHERE etapa = '$etapa' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener consejos por tipo
function getConsejosPorTipo($tipo) {
    global $conn;
    $tipo = $conn->real_escape_string($tipo);
    $query = "SELECT * FROM consejos WHERE tipo_consejo = '$tipo' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener un consejo específico
function getConsejoDetalleById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM consejos WHERE id = $id AND activo = 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// Obtener consejos aleatorios
function getConsejosAleatorios($limit = 6) {
    global $conn;
    $limit = intval($limit);
    $query = "SELECT * FROM consejos WHERE activo = 1 ORDER BY RAND() LIMIT $limit";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener categorías de consejos
function getCategorias_Consejos() {
    global $conn;
    $query = "SELECT DISTINCT categoria FROM consejos WHERE activo = 1 ORDER BY categoria";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Contar consejos por categoría
function contarConsejosCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT COUNT(*) as total FROM consejos WHERE categoria = '$categoria' AND activo = 1";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    return 0;
}
?>