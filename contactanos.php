<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parently</title>
    <link rel="stylesheet" href="homepage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>




<style>
 
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}
 
/* FONDO GENERAL */
body{
    background-color: #f5e8d9;
    padding: 40px;
}
 
 .navbar-nav .nav-link {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff !important;
            transition: 0.3s;
            padding: 8px 15px;
            border-radius: 20px;
        }

        .navbar-nav .nav-link:hover {
            background-color: #ffffff;
            color: #D94571 !important;
        }

        .navbar-nav .nav-link.active {
            background-color: #ffffff;
            color: #D94571 !important;
            border-bottom: 3px solid #00bcd4;
        }



/* CONTENEDOR */
.contacto{
    width: 100%;
}
 
/* PARTE SUPERIOR */
.contacto-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 50px;
}
 
.texto h1{
    color: #ff4f87;
    font-size: 50px;
    margin-bottom: 15px;
}
 
.texto p{
    font-size: 25px;
    color: #333;
    line-height: 1.5;
}
 
/* IMAGEN */
.imagen img{
    width: 320px;
}
 
/* CONTENEDOR DE ABAJO */
.contenedor-contacto{
    display: flex;
    justify-content: space-between;
    gap: 40px;
}
 
/* FORMULARIO */
.formulario{
    width: 55%;
    background-color: #f8b6c8;
    padding: 30px;
    border-radius: 25px;
}
 
.formulario h2{
    color: #ff4f87;
    margin-bottom: 25px;
    font-size: 32px;
}
 
.formulario label{
    display: block;
    margin-top: 20px;
    margin-bottom: 8px;
    font-weight: bold;
    font-size: 20px;
}
 
.formulario input,
.formulario textarea{
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 12px;
    outline: none;
    font-size: 16px;
}
 
.formulario textarea{
    height: 180px;
    resize: none;
}
 
.formulario button{
    width: 100%;
    padding: 18px;
    margin-top: 30px;
    border: none;
    border-radius: 15px;
    background-color: #ff5c93;
    color: white;
    font-size: 25px;
    cursor: pointer;
    transition: 0.3s;
}
 
.formulario button:hover{
    background-color: #ff3f7d;
}
 
/* INFO CONTACTO */
.info-contacto{
    width: 40%;
    background-color: #f8b6c8;
    padding: 30px;
    border-radius: 25px;
}
 
.info-contacto h2{
    color: #ff4f87;
    margin-bottom: 30px;
    font-size: 32px;
}
 
/* TARJETAS */
.card{
    background-color: #ff6b9d;
    color: white;
    padding: 25px;
    border-radius: 18px;
    margin-bottom: 25px;
}
 
.card h3{
    margin-bottom: 8px;
    font-size: 24px;
}
 
.card p{
    font-size: 18px;
}
 
/* RESPONSIVE */
@media(max-width: 900px){
 
    .contacto-header{
        flex-direction: column;
        text-align: center;
    }
 
    .contenedor-contacto{
        flex-direction: column;
    }
 
    .formulario,
    .info-contacto{
        width: 100%;
    }
 
    .imagen img{
        margin-top: 20px;
        width: 250px;
    }
 
}
 
</style>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">

    <!-- Logo + nombre (izquierda) -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">
      Parently
    </a>

    <!-- Botón responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Opciones (derecha) -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav mx-auto gap-2">
        <li class="nav-item">
          <a class="nav-link" href="recursos.php">Recursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Actividades</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Especialistas</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="#">Comunidades</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="contactanos.php">Contactanos</a>
        </li>
      </ul>
      
      <!-- Botones - Con sesión o sin sesión -->
      <div class="d-flex gap-2 align-items-center">
        <?php if (isset($_SESSION["usuario_nombre"])): ?>
          <!-- Usuario logueado -->
          <div class="profile-btn d-flex align-items-center gap-2">
            <a href="perfil.php" class="avatar-link">
              <div class="avatar-small">
                <?php echo strtoupper(substr($_SESSION["usuario_nombre"], 0, 1)); ?>
              </div>
            </a>
            <a href="perfil.php" class="profile-name"><?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></a>
            <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
          </div>
        <?php else: ?>
          <!-- Usuario sin sesión -->
          <a href="login.php" class="btn btn-outline-success">Iniciar Sesión</a>
          <a href="registro.php" class="btn btn-success">Registrarse</a>
        <?php endif; ?>
      </div>
    </div>

  </div>
</nav>
 

<section class="contacto">
 
    <!-- PARTE SUPERIOR -->
    <div class="contacto-header">
 
        <div class="texto">
            <h1>Contáctanos</h1>
            <p>
                Estamos aquí para ayudarte <br>
                en la crianza de tus hijos
            </p>
        </div>
 
        <div class="imagen">
            <!-- CAMBIA la imagen por la tuya -->
            <img src="familia.png" alt="Familia">
        </div>
 
    </div>
 
    <!-- PARTE INFERIOR -->
    <div class="contenedor-contacto">
 
        <!-- FORMULARIO -->
        <div class="formulario">
 
            <h2>¡Envíanos un mensaje!</h2>
 
            <label>Nombre</label>
            <input type="text">
 
            <label>Correo electrónico</label>
            <input type="email" placeholder="Tipo de consulta">
 
            <label>Mensaje</label>
            <textarea></textarea>
 
            <button>Enviar</button>
 
        </div>
 
        <!-- INFORMACIÓN -->
        <div class="info-contacto">
 
            <h2>Otras formas de contacto</h2>
 
            <div class="card">
                <h3>WhatsApp</h3>
                <p>+503 6786-3434</p>
            </div>
 
            <div class="card">
                <h3>Correo electrónico</h3>
                <p>soporte@parently.com</p>
            </div>
 
            <div class="card">
                <h3>Teléfono</h3>
                <p>+503 6834-5476</p>
            </div>
 
        </div>
 
    </div>
 
</section

</body>
</html>