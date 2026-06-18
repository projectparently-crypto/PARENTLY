<?php
session_start();

// Si no hay sesión, redirige a login
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit();
}

// Conexión a la BD para obtener datos del usuario
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del usuario
$user_id = $_SESSION["usuario_id"];
$stmt = $conn->prepare("SELECT nombre_usuario, email, fecha_registro FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nombre = $user["nombre_usuario"];
    $email = $user["email"];
    $fecha = $user["fecha_registro"];
} else {
    header("Location: login.php");
    exit();
}

$stmt->close();
$conn->close();

// Formatear fecha en español
$fecha_obj = new DateTime($fecha);
$fecha_formateada = $fecha_obj->format('d \d\e F \d\e Y');
$meses = [
    "January" => "enero",
    "February" => "febrero",
    "March" => "marzo",
    "April" => "abril",
    "May" => "mayo",
    "June" => "junio",
    "July" => "julio",
    "August" => "agosto",
    "September" => "septiembre",
    "October" => "octubre",
    "November" => "noviembre",
    "December" => "diciembre"
];

foreach ($meses as $en => $es) {
    $fecha_formateada = str_replace($en, $es, $fecha_formateada);
}

$inicial = strtoupper(substr($nombre, 0, 1));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Parently</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffe8f0 0%, #fff5f0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .navbar {
            background-color: #FFBDC8 !important;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 100%;
            margin-bottom: 30px;
        }

        .navbar-brand {
            font-weight: bold;
            color: #8b2a5e !important;
        }

        .container-perfil {
            background: white;
            border-radius: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            animation: slideIn 0.6s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6fa5 0%, #ff4081 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
            font-weight: bold;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(255, 64, 129, 0.3);
            animation: floatAvatar 3s ease-in-out infinite;
        }

        @keyframes floatAvatar {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        .nombre-usuario {
            font-size: 36px;
            font-weight: 700;
            color: #8b2a5e;
            margin-bottom: 10px;
        }

        .badge-premium {
            display: inline-block;
            background: linear-gradient(135deg, #ff6fa5 0%, #ff4081 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(255, 64, 129, 0.2);
        }

        .info-section {
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(135deg, #fef3f8 0%, #fff9f5 100%);
            border-radius: 20px;
            border-left: 4px solid #ff6fa5;
        }

        .info-label {
            color: #ff6fa5;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .info-content {
            color: #8b2a5e;
            font-size: 16px;
            font-weight: 500;
            word-break: break-all;
        }

        .botones-grupo {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-inicio {
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff6fa5 0%, #ff4081 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-inicio:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 64, 129, 0.3);
            color: white;
        }

        .btn-salir {
            padding: 12px 30px;
            background: transparent;
            color: #ff6fa5;
            border: 2px solid #ff6fa5;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-salir:hover {
            background: #ff6fa5;
            color: white;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .container-perfil {
                padding: 40px 25px;
            }

            .nombre-usuario {
                font-size: 28px;
            }

            .avatar {
                width: 100px;
                height: 100px;
                font-size: 40px;
            }

            .botones-grupo {
                flex-direction: column;
            }

            .btn-inicio, .btn-salir {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">
      Parently
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav mx-auto gap-2">
        <li class="nav-item">
          <a class="nav-link" href="recursos.php">Recursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="actividades.php">Actividades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="especialistas.php">Especialistas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comunidades.php">Comunidades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contactanos.php">Contactanos</a>
        </li>
      </ul>
      <div class="d-flex gap-2 align-items-center">
        <?php if (isset($_SESSION["usuario_nombre"])): ?>
          <div class="profile-btn d-flex align-items-center gap-2">
            <a href="php/perfil.php" class="avatar-link">
              <div class="avatar-small">
                <?php echo strtoupper(substr($_SESSION["usuario_nombre"], 0, 1)); ?>
              </div>
            </a>
            <a href="php/perfil.php" class="profile-name"><?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></a>
            <a href="php/logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
          </div>
        <?php else: ?>
          <a href="login.php" class="btn btn-outline-success">Iniciar Sesión</a>
          <a href="registro.php" class="btn btn-success">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- CONTENEDOR PERFIL -->
<div class="container-perfil">
    
    <!-- Avatar -->
    <div class="avatar">
        <?php echo $inicial; ?>
    </div>

    <!-- Nombre de usuario -->
    <h1 class="nombre-usuario"><?php echo htmlspecialchars($nombre); ?></h1>

    <!-- Badge Premium -->
    <div class="badge-premium">
        <i class="bi bi-star-fill"></i> Miembro Premium
    </div>

    <!-- Email -->
    <div class="info-section">
        <div class="info-label">
            <i class="bi bi-envelope"></i> Correo Electrónico
        </div>
        <div class="info-content"><?php echo htmlspecialchars($email); ?></div>
    </div>

    <!-- Fecha de Registro -->
    <div class="info-section">
        <div class="info-label">
            <i class="bi bi-calendar-event"></i> Miembro Desde
        </div>
        <div class="info-content"><?php echo htmlspecialchars($fecha_formateada); ?></div>
    </div>

    <!-- Botones -->
    <div class="botones-grupo">
        <a href="index.php" class="btn-inicio">
            <i class="bi bi-house"></i> Volver al Inicio
        </a>
        <a href="logout.php" class="btn-salir">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>