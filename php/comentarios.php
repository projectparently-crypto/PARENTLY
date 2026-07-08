<?php
session_start();
header("Content-Type: application/json");
include "db.php";

/* =========================
   VALIDAR SESIÓN
========================= */
if(!isset($_SESSION["usuario_id"])){
    echo json_encode([
        "ok" => false,
        "mensaje" => "Debes iniciar sesión"
    ]);
    exit;
}

/* =========================
   RECIBIR DATOS (FORMDATA)
========================= */
$foro    = $_POST["foro_id"] ?? 0;
$texto   = trim($_POST["comentario"] ?? "");
$parent  = (int)($_POST["parent_id"] ?? 0);
$anonimo = $_POST["anonimo"] ?? 0;

if($texto === ""){
    echo json_encode([
        "ok" => false,
        "mensaje" => "Comentario vacío"
    ]);
    exit;
}

$usuario = $_SESSION["usuario_id"];

/* =========================
   SUBIR IMÁGENES (MULTIPLE)
========================= */
$imagenes = [];

if(isset($_FILES["imagenes"]) && !empty($_FILES["imagenes"]["name"][0])){

    $dir = "../uploads/comentarios/";

    if(!is_dir($dir)){
        mkdir($dir, 0777, true);
    }

    foreach($_FILES["imagenes"]["tmp_name"] as $i => $tmp){

        if($_FILES["imagenes"]["error"][$i] === 0){

            $ext = pathinfo($_FILES["imagenes"]["name"][$i], PATHINFO_EXTENSION);

            $nombre = time() . "_" . uniqid() . "." . $ext;

            move_uploaded_file($tmp, $dir . $nombre);

            $imagenes[] = $nombre;
        }
    }
}

/* =========================
   CONVERTIR A JSON
========================= */
$imagenesJSON = !empty($imagenes) ? json_encode($imagenes) : null;

/* =========================
   INSERT EN BD
========================= */
$sql = "INSERT INTO comentarios
(foro_id, usuario_id, texto, parent_id, anonimo, imagenes)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if(!$stmt){
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error SQL: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "iisiss",
    $foro,
    $usuario,
    $texto,
    $parent,
    $anonimo,
    $imagenesJSON
);

if(!$stmt->execute()){
    echo json_encode([
        "ok" => false,
        "mensaje" => $stmt->error
    ]);
    exit;
}

$id = $conn->insert_id;

/* =========================
   DATOS USUARIO
========================= */
$sql = "SELECT nombre_usuario, foto_perfil
        FROM usuarios
        WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

/* =========================
   RESPUESTA JSON
========================= */
echo json_encode([
    "ok" => true,
    "id" => $id,
    "foro_id" => $foro,
    "texto" => $texto,
    "parent_id" => $parent,
    "fecha" => date("Y-m-d H:i:s"),
    "anonimo" => $anonimo,
    "likes" => 0,
    "imagenes" => $imagenes,
    "nombre_usuario" => $anonimo ? "Anónimo" : $user["nombre_usuario"],
    "foto_perfil" => $anonimo ? "" : $user["foto_perfil"]
]);

exit;