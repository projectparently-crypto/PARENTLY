<?php

header("Content-Type: application/json; charset=utf-8");

include "db.php";


$foro_id = $_GET["foro_id"] ?? 0;


$stmt = $conn->prepare(
"SELECT 
id,
nombre,
descripcion,
objetivo,
reglas,
fecha_creacion,
miembros
FROM foros
WHERE id = ?"
);


$stmt->bind_param("i",$foro_id);

$stmt->execute();


$resultado = $stmt->get_result();


echo json_encode(
$resultado->fetch_assoc()
);

?>