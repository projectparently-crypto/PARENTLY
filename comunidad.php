<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Parently - Comunidades</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="style/comunidades.css">
    <link rel="shortcut icon" href="photos/favicon.ico" type="image/x-icon">

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">

  <div class="container-fluid">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">


      <img
        src="img/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png"
        width="50"
        class="me-3"
      >


      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">


    </a>

    <!-- BOTON RESPONSIVE -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- OPCIONES -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

      <ul class="navbar-nav mx-auto gap-2">

        <li class="nav-item">
          <a class="nav-link" href="recursos.php">
            Recursos
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="actividades.php">
            Actividades
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="especialistas.php">
            Especialistas
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="comunidades.php">
            Comunidades
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="contactanos.php">
            Contactanos
          </a>
        </li>

      </ul>

      <!-- SESION -->
      <div class="d-flex gap-2 align-items-center">

        <?php if (isset($_SESSION["usuario_nombre"])): ?>

          <div class="profile-btn d-flex align-items-center gap-2">

            <a href="perfil.php" class="avatar-link">

              <div class="avatar-small">

                <?php
                  echo strtoupper(substr($_SESSION["usuario_nombre"],0,1));
                ?>

              </div>

            </a>

            <a href="perfil.php" class="profile-name">

              <?php
                echo htmlspecialchars($_SESSION["usuario_nombre"]);
              ?>

            </a>

            <a href="logout.php" class="btn btn-danger btn-sm">
              Cerrar Sesión
            </a>

          </div>

        <?php else: ?>

          <a href="login.php" class="btn btn-outline-success">
            Iniciar Sesión
          </a>

          <a href="registro.php" class="btn btn-success">
            Registrarse
          </a>

        <?php endif; ?>

      </div>

    </div>

  </div>

</nav>





<!-- ================= FOROS ================= -->

<section class="container py-4">

    <!-- TITULO -->
    <h2 class="forum-title">
        Foros
    </h2>



    <!-- ================= BANNER ================= -->

    <div class="forum-banner">

        <!-- BUSCADOR -->
        <div class="forum-search">

            <input
              type="text"
              placeholder="Ingresa el nombre del foro"
            >

            <button>

                <i class="fa-solid fa-magnifying-glass"></i>

                Buscar

            </button>

        </div>

        <!-- IMAGEN -->
        <img
          src="img/comunidades.jpg"
          alt="Banner"
          class="forum-banner-img"
        >

        <img src="../photos/comunidades.jpg"
             alt="Banner"
             class="forum-banner-img">
 
    </div>





    <!-- ================= TARJETAS ================= -->

    <div class="row g-4 mt-4 justify-content-center">



        <!-- EDAD ESCOLAR -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=1"
               class="community-card">

                <i class="fa-solid fa-graduation-cap"></i>

                <h5>Edad Escolar</h5>

            </a>

        </div>




        <!-- SUEÑO -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=2"
               class="community-card">

                <i class="fa-solid fa-bed"></i>

                <h5>Sueño</h5>

            </a>

        </div>




        <!-- ALIMENTACION -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=3"
               class="community-card">

                <i class="fa-solid fa-utensils"></i>

                <h5>Alimentación</h5>

            </a>

        </div>




        <!-- EMOCIONES -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=4"
               class="community-card">

                <i class="fa-regular fa-face-smile"></i>

                <h5>Emociones</h5>

            </a>

        </div>




        <!-- VINCULO -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=5"
               class="community-card">

                <i class="fa-regular fa-heart"></i>

                <h5>Vínculo Familiar</h5>

            </a>

        </div>




        <!-- DISCIPLINA -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=6"
               class="community-card">

                <i class="fa-solid fa-brain"></i>

                <h5>Disciplina Positiva</h5>

            </a>

        </div>




        <!-- EDUCACION -->
        <div class="col-md-6 col-6">

            <a href="foro.php?id=7"
               class="community-card">

                <i class="fa-solid fa-book-open"></i>

                <h5>Educación</h5>

            </a>

        </div>




        <!-- SALUD -->
        <div class="col-md-6 col-6">

            <a href="foro.php?id=8"
               class="community-card">

                <i class="fa-solid fa-heart-pulse"></i>

                <h5>Salud</h5>

            </a>

        </div>

    </div>

</section>





<!-- FOOTER -->

<footer class="community-footer">
    <img
      src="img/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png"
      alt="Logo"
    >
 
    <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png"
         alt="Logo">
 
    <h3>
      Parently
    </h3>

</footer>





<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>