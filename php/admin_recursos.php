<?php
session_start();
include 'db.php';

// Verificar si es admin
if (!isset($_SESSION["es_admin"]) || $_SESSION["es_admin"] != 1) {
    header("Location: login.php");
    exit();
}

// Agregar recurso
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    $titulo = $conn->real_escape_string($_POST["titulo"]);
    $descripcion = $conn->real_escape_string($_POST["descripcion"]);
    $categoria = $conn->real_escape_string($_POST["categoria"]);
    $tipo = $conn->real_escape_string($_POST["tipo"]);
    $etapa = $conn->real_escape_string($_POST["etapa"]);
    $imagen = $_POST["imagen"];
    
    // Guardar imagen (opcional - usar upload)
    $query = "INSERT INTO recursos (titulo, descripcion, categoria, tipo, etapa, imagen) 
              VALUES ('$titulo', '$descripcion', '$categoria', '$tipo', '$etapa', '$imagen')";
    
    if ($conn->query($query)) {
        echo "<div class='alert alert-success'>Recurso agregado correctamente</div>";
    }
}

// Obtener todos los recursos
$query = "SELECT * FROM recursos ORDER BY fecha_creacion DESC";
$recursos = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Admin - Recursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Gestionar Recursos</h1>
    
    <!-- Formulario para agregar -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Agregar Nuevo Recurso</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" class="form-control" name="titulo" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select class="form-control" name="categoria" required>
                        <option>Salud Mental</option>
                        <option>Nutrición</option>
                        <option>Desarrollo</option>
                        <option>Tecnología</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo</label>
                    <select class="form-control" name="tipo" required>
                        <option>articulo</option>
                        <option>video</option>
                        <option>guia</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Etapa</label>
                    <select class="form-control" name="etapa" required>
                        <option>embarazo</option>
                        <option>primeros_años</option>
                        <option>pre_adolescencia</option>
                        <option>adolescencia</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL Imagen</label>
                    <input type="text" class="form-control" name="imagen" required>
                </div>
                <button type="submit" name="agregar" class="btn btn-primary">Agregar Recurso</button>
            </form>
        </div>
    </div>

    <!-- Lista de recursos -->
    <div class="card">
        <div class="card-header">
            <h5>Recursos Existentes</h5>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Tipo</th>
                        <th>Etapa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($recurso = $recursos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($recurso['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($recurso['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($recurso['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($recurso['etapa']); ?></td>
                            <td>
                                <a href="editar-recurso.php?id=<?php echo $recurso['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="eliminar-recurso.php?id=<?php echo $recurso['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>