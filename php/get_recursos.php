<?php
include "db.php";

function getRecursosMasVistos($limit = 2){
    global $conn;

    $limit = intval($limit);

    $sql = "SELECT *
            FROM recursos
            WHERE activo = 1
            ORDER BY fecha_creacion DESC
            LIMIT $limit";

    return $conn->query($sql);
}

/**
 * Obtener recurso por ID
 */
function getRecursoById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM recursos WHERE id = $id AND activo = 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

/**
 * Obtener recursos por categoría
 */
function getRecursosPorCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT * FROM recursos WHERE categoria = '$categoria' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Obtener recursos por etapa
 */
function getRecursosPorEtapa($etapa) {
    global $conn;
    $etapa = $conn->real_escape_string($etapa);
    $query = "SELECT * FROM recursos WHERE etapa = '$etapa' AND activo = 1 ORDER BY fecha_creacion DESC";
    $result = $conn->query($query);
    return $result ? $result : null;
}

function getEtapas(){
    global $conn;

    return $conn->query("SELECT * FROM etapas ORDER BY id");
}

/**
 * Obtener categorías de recursos
 */
function getCategorias_Recursos() {
    global $conn;
    $query = "SELECT DISTINCT categoria FROM recursos WHERE activo = 1 ORDER BY categoria";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Obtener recursos aleatorios
 */
function getRecursosAleatorios($limit = 6) {
    global $conn;
    $limit = intval($limit);
    $query = "SELECT * FROM recursos WHERE activo = 1 ORDER BY RAND() LIMIT $limit";
    $result = $conn->query($query);
    return $result ? $result : null;
}

/**
 * Contar recursos por categoría
 */
function contarRecursosCategoria($categoria) {
    global $conn;
    $categoria = $conn->real_escape_string($categoria);
    $query = "SELECT COUNT(*) as total FROM recursos WHERE categoria = '$categoria' AND activo = 1";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    return 0;
}

/**
 * Obtener todos los recursos con paginación
 */
function getAllRecursos($page = 1, $limit = 12) {
    global $conn;
    $page = intval($page);
    $limit = intval($limit);
    $offset = ($page - 1) * $limit;
    
    $query = "SELECT * FROM recursos WHERE activo = 1 ORDER BY fecha_creacion DESC LIMIT $limit OFFSET $offset";
    return $conn->query($query);
}

/**
 * Contar total de recursos
 */
function countTotalRecursos() {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM recursos WHERE activo = 1";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    return 0;
}
?>
