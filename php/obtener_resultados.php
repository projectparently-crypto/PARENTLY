<?php

include("conexion.php");

$id = intval($_GET["id_situacion"]);

$sql="SELECT

o.id_opcion,

o.texto,

COUNT(r.id_respuesta) total

FROM opciones_situacion o

LEFT JOIN respuestas_situacion r

ON o.id_opcion=r.id_opcion

WHERE o.id_situacion=$id

GROUP BY o.id_opcion";

$res=mysqli_query($conexion,$sql);

$total=0;

$datos=[];

while($fila=mysqli_fetch_assoc($res)){

$total+=$fila["total"];

$datos[]=$fila;

}

foreach($datos as &$fila){

if($total==0){

$fila["porcentaje"]=0;

}else{

$fila["porcentaje"]=round(

($fila["total"]/$total)*100

);

}

}

header("Content-Type: application/json");

echo json_encode($datos);