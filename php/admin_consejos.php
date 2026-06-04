<?php
session_start();
include 'db.php';

// Verificar si es admin
if (!isset($_SESSION["es_admin"]) || $_SESSION["es_admin"] != 1) {
    header("Location: login.php");
    exit();
}

// Agregar consejo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {
    $titulo = $conn->real_escape_string($_POST["titulo"]);
    $descripcion = $conn->real_escape_string($_POST["descripcion"]);
    $contenido_largo = $conn->real_escape_string($_POST["contenido_largo"] ?? '');
    $imagen = $_POST["imagen"];
    $categoria = $conn->real_escape_string($_POST["categoria"]);
    $tipo_consejo = $conn->real_escape_string($_POST["tipo_consejo"]);
    $etapa = $conn->real_escape_string($_POST["etapa"]);
    $icono = $_POST["icono"] ?? '';
    $tiempo_lectura = intval($_POST["tiempo_lectura"] ?? 0);
    
    $query = "INSERT INTO consejos (titulo, descripcion, contenido_largo, imagen, categoria, tipo_consejo, etapa, icono, tiempo_lectura) 
              VALUES ('$titulo', '$descripcion', '$contenido_largo', '$imagen', '$categoria', '$tipo_consejo', '$etapa', '$icono', $tiempo_lectura)";
    
    if ($conn->query($query)) {
        $success_msg = "✓ Consejo agregado correctamente";
    } else {
        $error_msg = "✗ Error al agregar: " . $conn->error;
    }
}

// Eliminar consejo
if (isset($_GET["eliminar"])) {
    $id = intval($_GET["eliminar"]);
    $query = "UPDATE consejos SET activo = 0 WHERE id = $id";
    if ($conn->query($query)) {
        $success_msg = "✓ Consejo eliminado";
    }
}

// Obtener todos los consejos
$query = "SELECT * FROM consejos ORDER BY fecha_creacion DESC";
$consejos = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Consejos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .sidebar { background: #FFBDC8; height: 100vh; }
        .card { border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .btn-primary { background: #D94571; border: none; }
        .btn-primary:hover { background: #e91e63; }
        .table-hover tbody tr:hover { background-color: #f5e6d3; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar p-3">
            <h4 class="text-white mb-4">📋 Admin Panel</h4>
            <ul class="list-unstyled">
                <li><a href="admin_consejos.php" class="text-dark text-decoration-none">💡 Consejos</a></li>
                <li><a href="admin_recursos.php" class="text-dark text-decoration-none">📚 Recursos</a></li>
                <li><a href="admin_etapas.php" class="text-dark text-decoration-none">👶 Etapas</a></li>
            </ul>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="col-md-10 p-4">
            <h1 class="mb-4">Gestionar Consejos del Día a Día</h1>

            <?php if(isset($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(isset($error_msg)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- FORMULARIO AGREGAR -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">➕ Agregar Nuevo Consejo</h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Título *</label>
                                <input type="text" class="form-control" name="titulo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Categoría *</label>
                                <select class="form-control" name="categoria" required>
                                    <option>Salud Mental</option>
                                    <option>Nutrición</option>
                                    <option>Desarrollo</option>
                                    <option>Relaciones</option>
                                    <option>Seguridad</option>
                                    <option>Educación</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Descripción Corta *</label>
                                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contenido Largo</label>
                                <textarea class="form-control" name="contenido_largo" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tipo *</label>
                                <select class="form-control" name="tipo_consejo" required>
                                    <option value="articulo">Artículo</option>
                                    <option value="video">Vídeo</option>
                                    <option value="tip">Tip</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Etapa *</label>
                                <select class="form-control" name="etapa" required>
                                    <option value="embarazo">Embarazo</option>
                                    <option value="primeros_años">Primeros años</option>
                                    <option value="pre_adolescencia">Pre-Adolescencia</option>
                                    <option value="adolescencia">Adolescencia</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Ícono (Font Awesome)</label>
                                <input type="text" class="form-control" name="icono" placeholder="fa-brain">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tiempo Lectura (min)</label>
                                <input type="number" class="form-control" name="tiempo_lectura" value="5">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">URL Imagen *</label>
                                <input type="text" class="form-control" name="imagen" required>
                            </div>
                        </div>

                        <button type="submit" name="agregar" class="btn btn-primary">✓ Agregar Consejo</button>
                    </form>
                </div>
            </div>

            <!-- TABLA CONSEJOS -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">📑 Consejos Existentes</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th>Etapa</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($consejo = $consejos->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $consejo['id']; ?></td>
                                    <td><?php echo htmlspecialchars(substr($consejo['titulo'], 0, 30)); ?></td>
                                    <td><?php echo htmlspecialchars($consejo['categoria']); ?></td>
                                    <td><span class="badge bg-info"><?php echo $consejo['tipo_consejo']; ?></span></td>
                                    <td><?php echo htmlspecialchars($consejo['etapa']); ?></td>
                                    <td>
                                        <?php if($consejo['activo']): ?>
                                            <span class="badge bg-success">✓ Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">✗ Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($consejo['fecha_creacion'])); ?></td>
                                    <td>
                                        <a href="editar-consejo.php?id=<?php echo $consejo['id']; ?>" class="btn btn-sm btn-warning">✏️</a>
                                        <a href="?eliminar=<?php echo $consejo['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">🗑️</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
