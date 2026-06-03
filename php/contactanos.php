<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parently</title>
 
<link rel="stylesheet" href="../style/contactanos.css">
 
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
 
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 

</head>
 
<body>
 
<!-- NAVBAR -->
 
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

 
<!-- =========================
     CONTACTO
========================= -->
 
<section class="contacto">
 
    <div class="contacto-header">
 
        <div class="texto">
 
            <h1>Contáctanos</h1>
 
            <p>
                Estamos aquí para ayudarte
                en la crianza de tus hijos
            </p>
 
        </div>
 
        <div class="imagen">
 
            <img src="../photos/contactanos/familia.png" alt="Familia">
 
        </div>
 
    </div>
 
    <div class="contenedor-contacto">
 
        <!-- FORMULARIO -->
 
        <div class="formulario">

            <form method="POST">

                <h2>¡Envíanos un mensaje!</h2>

                <label>Nombre</label>
                <input type="text" name="nombre">

                <label>Correo electrónico</label>
                <input type="email" name="email" placeholder="correo electronico">

                <label>Mensaje</label>
                <textarea name="mensaje"></textarea>

                <button type="submit">Enviar</button>

            </form>

        </div>
 
        <!-- INFO -->
 
        <div class="info-contacto">

    <h2>Otras formas de contacto</h2>

    <a href="https://wa.me/50367863434" class="card-link" target="_blank">
        <div class="card-contact whatsapp">
            <div class="icono"><i class="fa-brands fa-whatsapp"></i></div>
            <div>
                <h3>WhatsApp</h3>
                <p>+503 6786-3434</p>
            </div>
        </div>
    </a>

    <a href="mailto:tucorreo@gmail.com" class="card-link">
        <div class="card-contact email">
            <div class="icono"> <i class="bi bi-envelope"></i></div>
            <div>
                <h3>Correo electrónico</h3>
                <p>soporte@parently.com</p>
            </div>
        </div>
    </a>

    <a href="tel:+50368345476" class="card-link">
        <div class="card-contact phone">
            <div class="icono"><i class="fa-solid fa-mobile"></i></div>
            <div>
                <h3>Teléfono</h3>
                <p>+503 6834-5476</p>
            </div>

        </div>
    </a>

    <a href="https://www.instagram.com/parently_team?igsh=d251dXlzcnF4anp5" class="card-link">
        <div class="card-contact Instagram">
            <div class="icono"><i class="bi bi-instagram"></i></div>
            <div>
                <h3>Instagram</h3>
                <p>@Parently</p>
            </div>

        </div>
    </a>
    

    <a href="https://www.facebook.com/share/g/1CgdV2AhZ4/" class="card-link">
        <div class="card-contact facebook">
            <div class="icono"><i class="bi bi-facebook"></i></i></div>
            <div>
                <h3>Facebook</h3>
                <p>@ParentlyFC</p>
            </div>

        </div>
    </a>

</div>
    </div>
 
</section>
 
<!-- =========================
     COMENTARIOS
========================= -->
 
<section class="comentarios">
 
    <div class="comentarios-box">
 
        <form method="POST">

         <h2>¿Te ha sido útil Parently?</h2>

            <div class="rating">
                <input type="radio" name="rating" value="5" id="star5">
                <label for="star5">★</label>

                <input type="radio" name="rating" value="4" id="star4">
                <label for="star4">★</label>

                <input type="radio" name="rating" value="3" id="star3">
                <label for="star3">★</label>

                <input type="radio" name="rating" value="2" id="star2">
                <label for="star2">★</label>

                <input type="radio" name="rating" value="1" id="star1">
                <label for="star1">★</label>
            </div>

            <textarea name="comentario" placeholder="Déjanos tus comentarios..."></textarea>

            <div class="comentario-footer">

                <img src="../photos/contactanos/osito.png" alt="Osito">

                <button type="submit">Enviar comentario</button>

            </div>

        </form>
 
    </div>
 
    <div class="seguridad">
        🤍 Tu información es segura con nosotros
    </div>
 
</section>
 
<!-- Bootstrap JS -->
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
 
</body>
</html>