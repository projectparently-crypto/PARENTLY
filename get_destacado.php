<?php

include "conexion.php";

$foro_id = $_GET["foro_id"] ?? 1;

$sql = "SELECT usuario, fecha_union
        FROM participantes
        WHERE foro_id = ?
        ORDER BY fecha_union ASC
        LIMIT 1";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $foro_id);

$stmt->execute();

$resultado = $stmt->get_result();

$data = $resultado->fetch_assoc();

header("Content-Type: application/json");

echo json_encode($data);