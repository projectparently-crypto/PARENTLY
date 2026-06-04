<?php
session_start();
$error = "";

$servername = "localhost";
$username = "root";
$password = "";
$database = "db_parently"; // Cambia esto

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = trim($_POST["nombre_usuario"]);
    $contraseña = $_POST["contraseña"];

    if (empty($nombre_usuario) || empty($contraseña)) {
        $error = "Completa todos los campos.";
    } else {
        $stmt = $conn->prepare("SELECT id, nombre_usuario, contraseña FROM usuarios WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($contraseña, $row["contraseña"])) {
                $_SESSION["usuario_id"] = $row["id"];
                $_SESSION["usuario_nombre"] = $row["nombre_usuario"];
                $stmt->close();
                $conn->close();
                header("Location: index.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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
    align-items: center;
    justify-content: center;
}

.container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    max-width: 1200px;
    width: 90%;
    background: white;
    border-radius: 40px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.left-section {
    background: linear-gradient(135deg, #fef3f8 0%, #fff9f5 100%);
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.heart-logo {
    color: #8b2a5e;
    font-size: 60px;
    margin-bottom: 30px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.left-section h1 {
    color: #8b2a5e;
    font-size: 48px;
    margin-bottom: 40px;
    font-weight: 700;
}

.form {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-group input {
    width: 100%;
    padding: 15px 20px 15px 50px;
    background: linear-gradient(135deg, #ffb3d9 0%, #ffb3d9 100%);
    border: none;
    border-radius: 25px;
    font-size: 15px;
    color: #8b2a5e;
    transition: all 0.3s ease;
    outline: none;
}

.input-group input::placeholder {
    color: rgba(139, 42, 94, 0.6);
}

.input-group input:focus {
    transform: scale(1.05);
    box-shadow: 0 5px 20px rgba(255, 105, 180, 0.3);
}

.input-group .icon {
    color: black;
    position: absolute;
    right: 20px;
    font-size: 20px;
    pointer-events: none;
}

.btn-primary {
    padding: 15px 30px;
    background: linear-gradient(135deg, #FBAEBA 0%, #E22F4B 100%);
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255, 64, 129, 0.3);
}

.btn-primary:active {
    transform: translateY(-1px);
}

.alert {
    padding: 12px 15px;
    border-radius: 10px;
    font-size: 14px;
    text-align: center;
}

.alert-error {
    background: #ffcccc;
    color: #c41e3a;
    border-left: 4px solid #c41e3a;
}

.alert-success {
    background: #ccffcc;
    color: #2d9542;
    border-left: 4px solid #2d9542;
}

.social-text {
    color: #ff9db5;
    font-size: 14px;
    margin: 25px 0 15px;
}

.social-icons {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.social-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.social-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.login-link {
    margin-top: 20px;
    color: #8b2a5e;
    font-size: 14px;
}

.login-link a {
    color: #ff4081;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s;
}

.login-link a:hover {
    color: #ff6fa5;
}

.right-section {
    background: linear-gradient(135deg, #FBAEBA 0%, #E22F4B 100%);
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
}

.right-section h2 {
    font-size: 42px;
    margin-bottom: 15px;
    font-weight: 700;
}

.right-section p {
    font-size: 16px;
    margin-bottom: 30px;
    opacity: 0.95;
}

.btn-secondary {
    padding: 12px 40px;
    background: transparent;
    color: white;
    border: 2px solid white;
    border-radius: 25px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-secondary:hover {
    background: white;
    color: #ff4081;
    transform: translateY(-3px);
}

.login-container {
    grid-template-columns: 1fr 1fr;
}

.login-left {
    background: linear-gradient(135deg, #FBAEBA 0%, #E22F4B 100%);
    color: white;
    padding: 60px 40px;
}

.login-left h2 {
    font-size: 42px;
    margin-bottom: 15px;
    font-weight: 700;
}

.login-left p {
    font-size: 16px;
    margin-bottom: 30px;
    opacity: 0.95;
}

.login-right {
    background: linear-gradient(135deg, #fef3f8 0%, #fff9f5 100%);
    padding: 60px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.login-right h1 {
    color: #8b2a5e;
}

.forgot-password {
    color: #ff6fa5;
    text-decoration: none;
    font-size: 14px;
    text-align: right;
    margin-bottom: 10px;
    transition: color 0.3s;
}

.forgot-password:hover {
    color: #ff4081;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .container {
        grid-template-columns: 1fr;
        width: 95%;
    }

    .left-section,
    .right-section,
    .login-left,
    .login-right {
        padding: 40px 30px;
    }

    .left-section h1,
    .right-section h2,
    .login-left h2,
    .login-right h1 {
        font-size: 36px;
    }

    .heart-logo {
        font-size: 50px;
    }
}

.social-btn {
    display: flex;
    margin-top: 10px;  
    gap: 20px;
    justify-content: center;
}
.social-btn i {
    color: #d44f92 ;
    font-size: 1.5rem;
    display: flex;
    margin-top: 8px;
    gap: 20px;
    justify-content: center;
}

    </style>
</head>
<body>
    <div class="container login-container">
        <div class="left-section login-left">
            <h2>Hola, bienvenido.</h2>
            <p>¿No tienes una cuenta?</p>
            <a href="registro.php" class="btn-secondary">Registrarse.</a>
        </div>

        <div class="right-section login-right">
            <div class="heart-logo">
                <i class="bi bi-door-open-fill"></i>
            </div>
            <h1>Iniciar sesión</h1>

            <form method="POST" class="form">
                <div class="input-group">
                    <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
                    <span class="icon">
                            <i class="bi bi-person-fill"></i>
                    </span>
                </div>

                <div class="input-group">
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                    <span class="icon">
                         <i class="bi bi-lock-fill"></i>
                    </span>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>

                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>

                <button type="submit" class="btn-primary">Iniciar sesión</button>
            </form>

            <div class="social-icons">
                <a href="https://whatsapp.com/channel/0029VbD4Q1CEawdpYOZHis1g" class="social-btn">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/share/g/1CgdV2AhZ4/" class="social-btn">
                    <i class="bi bi-facebook"></i>
                </a>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
