<?php
include 'db.php';

// Obtener todas las guías de la tabla guias
function getGuiasParaFamilias($limit = null) {
    global $conn;
    $query = "SELECT * FROM guias WHERE activo = 1 ORDER BY fecha_creacion DESC";
    if ($limit) {
        $limit = intval($limit);
        $query .= " LIMIT $limit";
    }
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener guías por categoría
function getGuiasPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT * FROM guias WHERE categoria = '$categoria' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener guías por etapa
function getGuiasPorEtapa($etapa) {
    global $conn;
    $etapa = $conn->real_escape_string($etapa);
    $query = "SELECT * FROM guias WHERE etapa = '$etapa' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener guías por tipo
function getGuiasPorTipo($tipo) {
    global $conn;
    $tipo = $conn->real_escape_string($tipo);
    $query = "SELECT * FROM guias WHERE tipo_guia = '$tipo' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener una guía específica
function getGuiaDetalleById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM guias WHERE id = $id AND activo = 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

// Obtener guías aleatorias
function getGuiasAleatorias($limit = 4) {
    global $conn;
    $limit = intval($limit);
    $query = "SELECT * FROM guias WHERE activo = 1 ORDER BY RAND() LIMIT $limit";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Obtener categorías de guías
function getCategorias_Guias() {
    global $conn;
    $query = "SELECT DISTINCT categoria FROM guias WHERE activo = 1 ORDER BY categoria";
    $result = $conn->query($query);
    return $result ? $result : null;
}

// Contar guías por categoría
function contarGuiasCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT COUNT(*) as total FROM guias WHERE categoria = '$categoria' AND activo = 1";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    return 0;
}
?>