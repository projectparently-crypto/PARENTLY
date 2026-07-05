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

function getEtapas(){
    global $conn;

    return $conn->query("SELECT * FROM etapas ORDER BY id");
}