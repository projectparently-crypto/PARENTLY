<?php
include "db.php";

/**
 * Obtener guías más vistas/recientes
 */
function getGuiasMasVistas($limit = 2){
    global $conn;

    $limit = intval($limit);

    $sql = "SELECT *
            FROM guias
            WHERE activo = 1
            ORDER BY fecha_creacion DESC
            LIMIT $limit";

    return $conn->query($sql);
}

/**
 * Obtener guía por ID
 */
function getGuiaById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM guias WHERE id = $id AND activo = 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

/**
 * Obtener guías por categoría
 */
function getGuiasPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT * FROM guias WHERE categoria = '$categoria' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Obtener guías por tipo
 */
function getGuiasPorTipo($tipo) {
    global $conn;
    $tipo = $conn->real_escape_string($tipo);
    $query = "SELECT * FROM guias WHERE tipo_guia = '$tipo' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Obtener guías por etapa
 */
function getGuiasPorEtapa($etapa) {
    global $conn;
    $etapa = $conn->real_escape_string($etapa);
    $query = "SELECT * FROM guias WHERE etapa = '$etapa' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Obtener categorías de guías
 */
function getCategorias_Guias() {
    global $conn;
    $query = "SELECT DISTINCT categoria FROM guias WHERE activo = 1 ORDER BY categoria";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Obtener tipos de guías
 */
function getTiposGuias() {
    global $conn;
    $query = "SELECT DISTINCT tipo_guia FROM guias WHERE activo = 1 ORDER BY tipo_guia";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Obtener guías aleatorias
 */
function getGuiasAleatorias($limit = 6) {
    global $conn;
    $limit = intval($limit);
    $query = "SELECT * FROM guias WHERE activo = 1 ORDER BY RAND() LIMIT $limit";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Contar guías por categoría
 */
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

/**
 * Obtener todas las guías con paginación
 */
function getAllGuias($page = 1, $limit = 12) {
    global $conn;
    $page = intval($page);
    $limit = intval($limit);
    $offset = ($page - 1) * $limit;
    
    $query = "SELECT * FROM guias WHERE activo = 1 ORDER BY fecha_creacion DESC LIMIT $limit OFFSET $offset";
    return $conn->query($query);
}

/**
 * Contar total de guías
 */
function countTotalGuias() {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM guias WHERE activo = 1";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    return 0;
}
?>
