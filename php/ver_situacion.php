📚 Biblioteca de situaciones

</h1>

<p>

Explora situaciones anteriores,
conoce cómo respondió la comunidad
y continúa aprendiendo.

</p>

</header>

<div class="contenedor-situaciones">

<?php

while($fila=mysqli_fetch_assoc($situaciones)){

?>

<div class="card-historial">

<h3>

<?= htmlspecialchars($fila["titulo"]); ?>

</h3>

<p>

<?= substr(htmlspecialchars($fila["descripcion"]),0,120); ?>...

</p>

<div class="fecha">

<?= $fila["fecha_publicacion"]; ?>

</div>

<a

href="ver_situacion.php?id=<?= $fila["id_situacion"]; ?>"

class="btn btn-primary">

Ver situación

</a>

</div>

<?php } ?>

</div>