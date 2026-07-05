<?php

include("conexion.php");

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<title>Categorías</title>

<link rel="stylesheet" href="../style/experiencias.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container py-5">

<h2 class="mb-4">

Todas las categorías

</h2>

<div class="row">

<?php

$sql="SELECT * FROM categorias_experiencias ORDER BY nombre";

$resultado=mysqli_query($conexion,$sql);

while($cat=mysqli_fetch_assoc($resultado)){

?>

<div class="col-md-4 mb-3">

<a

href="experiencias.php?categoria=<?= $cat['id_categoria']; ?>"

class="age-tab d-flex justify-content-center align-items-center">

<?= htmlspecialchars($cat['nombre']); ?>

</a>

</div>

<?php

}

?>

</div>

</div>

</body>

</html>