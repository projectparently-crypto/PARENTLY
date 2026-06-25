<?php

require_once 'conexion.php';

session_start();

$id_usuario = $_SESSION['id_usuario'];

$id_experiencia = $_POST['id_experiencia'];
$tipo = $_POST['tipo'];

$sql = "SELECT *
        FROM reacciones_experiencias
        WHERE id_experiencia = ?
        AND id_usuario = ?";

$stmt = $conexion->prepare($sql);
$stmt->execute([$id_experiencia,$id_usuario]);

$reaccion = $stmt->fetch();

if($reaccion){

    if($reaction['tipo'] == $tipo){

        $sql = "DELETE
                FROM reacciones_experiencias
                WHERE id_experiencia = ?
                AND id_usuario = ?";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $id_experiencia,
            $id_usuario
        ]);

        echo json_encode([
            'estado'=>'eliminada'
        ]);

    }else{

        $sql = "UPDATE reacciones_experiencias
                SET tipo = ?
                WHERE id_experiencia = ?
                AND id_usuario = ?";

        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            $tipo,
            $id_experiencia,
            $id_usuario
        ]);

        echo json_encode([
            'estado'=>'agregada'
        ]);
    }

}else{

    $sql = "INSERT INTO reacciones_experiencias
            (id_experiencia,id_usuario,tipo)
            VALUES (?,?,?)";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        $id_experiencia,
        $id_usuario,
        $tipo
    ]);

    echo json_encode([
        'estado'=>'agregada'
    ]);
}