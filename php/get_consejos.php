<?php
session_start();
include 'db.php';

// Obtener todos los consejos
function getConsejos($limit = null) {
    global $conn;
    $query = "SELECT * FROM consejos WHERE activo = 1 ORDER BY fecha_creacion DESC";
    if ($limit) {
        $query .= " LIMIT $limit";
    }
    return $conn->query($query);
}

// Obtener consejos por categoría
function getConsejoPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT * FROM consejos WHERE categoria = '$categoria' AND activo = 1 ORDER BY fecha_creacion DESC";
    return $conn->query($query);
}

// Obtener consejos por etapa
function getConsejoPorEtapa($etapa) {
    global $conn;
    $etapa = $conn->real_escape_string($etapa);
    $query = "SELECT * FROM consejos WHERE etapa = '$etapa' AND activo = 1 ORDER BY fecha_creacion DESC";
    return $conn->query($query);
}

// Obtener consejos por tipo
function getConsejoPorTipo($tipo) {
    global $conn;
    $tipo = $conn->real_escape_string($tipo);
    $query = "SELECT * FROM consejos WHERE tipo_consejo = '$tipo' AND activo = 1 ORDER BY fecha_creacion DESC";
    return $conn->query($query);
}

// Obtener un consejo específico
function getConsejoById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM consejos WHERE id = $id AND activo = 1";
    return $conn->query($query)->fetch_assoc();
}

// Obtener consejos ordenados aleatoriamente (para destacar)
function getConsejosAleatorios($limit = 6) {
    global $conn;
    $query = "SELECT * FROM consejos WHERE activo = 1 ORDER BY RAND() LIMIT $limit";
    return $conn->query($query);
}

// Obtener categorías únicas
function getCategorias() {
    global $conn;
    $query = "SELECT DISTINCT categoria FROM consejos WHERE activo = 1 ORDER BY categoria";
    return $conn->query($query);
}

// Contar consejos por categoría
function contarPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT COUNT(*) as total FROM consejos WHERE categoria = '$categoria' AND activo = 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>
