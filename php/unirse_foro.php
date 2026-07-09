<?php

header("Content-Type: application/json; charset=utf-8");

session_start();

include "db.php";


$data = json_decode(file_get_contents("php://input"), true);


$foro_id = $data["foro_id"] ?? null;
$usuario_id = $_SESSION["usuario_id"] ?? null;


if(!$foro_id || !$usuario_id){

    echo json_encode([
        "success" => false,
        "error" => "datos_faltantes"
    ]);

    exit;
}


/* ==================================
   VERIFICAR SI YA ESTÁ PARTICIPANDO
================================== */

$check = $conn->prepare(
    "SELECT id FROM participantes 
     WHERE foro_id = ? 
     AND usuario_id = ?"
);

$check->bind_param(
    "ii",
    $foro_id,
    $usuario_id
);

$check->execute();


$result = $check->get_result();



/* ==================================
   SI YA ESTÁ → SALIR DEL FORO
================================== */

if($result->num_rows > 0){


    $delete = $conn->prepare(
        "DELETE FROM participantes 
         WHERE foro_id = ? 
         AND usuario_id = ?"
    );


    $delete->bind_param(
        "ii",
        $foro_id,
        $usuario_id
    );


    $ok = $delete->execute();



}


/* ==================================
   SI NO ESTÁ → UNIRSE
================================== */

else{


    $insert = $conn->prepare(
        "INSERT INTO participantes
        (foro_id, usuario_id)
        VALUES (?, ?)"
    );


    $insert->bind_param(
        "ii",
        $foro_id,
        $usuario_id
    );


    $ok = $insert->execute();



}



/* ==================================
   ACTUALIZAR CANTIDAD DE MIEMBROS
================================== */


$count = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM participantes
     WHERE foro_id = ?"
);


$count->bind_param(
    "i",
    $foro_id
);


$count->execute();


$total = $count
    ->get_result()
    ->fetch_assoc()["total"];



$update = $conn->prepare(
    "UPDATE foros 
     SET miembros = ?
     WHERE id = ?"
);


$update->bind_param(
    "ii",
    $total,
    $foro_id
);


$update->execute();



/* ==================================
   RESPUESTA
================================== */


echo json_encode([

    "success" => $ok,

    "estado" => ($result->num_rows > 0)
        ? "salio"
        : "unido",

    "total_miembros" => (int)$total

]);

?>