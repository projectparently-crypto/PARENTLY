<?php
session_start();
$busqueda = $_GET['busqueda'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Parently - Comunidades</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
      <link rel="stylesheet" href="../style/navbar.css">
      <link rel="stylesheet" href="../style/comunidades.css">

      <style>
    .footer {
    background-color: #efb3c2;
    padding: 30px 50px;
    margin-top: 10px;
}

.footer-container {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-right: 80px;
    justify-content: space-between;
    max-width: 1200px;
    margin: auto;
    padding-left: 40px;
}

/* TÍTULO */
.footer-content h2 {
    color: white;
    font-size: 40px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* COLUMNAS */
.footer-link{
  color: white;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
 
  transition: all 0.3s ease;
}

/* EFECTO AL PASAR EL CURSOR */
.footer-link:hover{
  color: #d85999;
  transform: translateX(8px) scale(1.05);
  text-shadow: 0 0 8px rgba(255, 51, 187, 0.7);
}

.footer-link i{
  transition: transform 0.3s ease;
}

.footer-link:hover i{
  transform: rotate(10deg) scale(1.2);
}

.footer-links {
    display: flex;
    gap: 80px;
}

/* TEXTO */
.footer-column p {
    color: white;
    font-size: 20px;
    margin-bottom: 15px;
 
    display: flex;
    align-items: center;
    gap: 12px;
}

/* ICONOS */
.footer-column i {
    font-size: 28px;
    color: white;
    transition: 0.3s ease;
}

/* HOVER */
.footer-column p:hover i {
    transform: scale(1.2);
    color: #D94571;
}

.footer-logo img {
    width: 200px;
    height: auto;
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
            <a href="perfil.php" class="avatar-link">
              <div class="avatar-small">
                <?php echo strtoupper(substr($_SESSION["usuario_nombre"], 0, 1)); ?>
              </div>
            </a>
            <a href="perfil.php" class="profile-name"><?php echo htmlspecialchars($_SESSION["usuario_nombre"]); ?></a>
            <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
          </div>
        <?php else: ?>
          <a href="login.php" class="btn btn-outline-success">Iniciar Sesión</a>
          <a href="registro.php" class="btn btn-success">Registrarse</a>
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

      <img src="https://upload.wikimedia.org/wikipedia/commons/c/ce/Gente_en_Iquitos.JPG" class="foro-img">

      <form class="forum-search">
        <input type="text" name="busqueda" placeholder="Buscar foro">
        <button type="submit">Buscar</button>
      </form>

    </div>





    <!-- ================= TARJETAS ================= -->

    <div class="row g-4 mt-4 justify-content-center">



        <!-- EDAD ESCOLAR -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=1"
               class="community-card card-item">

                <i class="fa-solid fa-graduation-cap"></i>

                <h5>Edad Escolar</h5>

            </a>

        </div>




        <!-- SUEÑO -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=2"
                class="community-card card-item">

                <i class="fa-solid fa-bed"></i>

                <h5>Sueño</h5>

            </a>

        </div>




        <!-- ALIMENTACION -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=3"
                class="community-card card-item">

                <i class="fa-solid fa-utensils"></i>

                <h5>Alimentación</h5>

            </a>

        </div>




        <!-- EMOCIONES -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=4"
                class="community-card card-item">

                <i class="fa-regular fa-face-smile"></i>

                <h5>Emociones</h5>

            </a>

        </div>




        <!-- VINCULO -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=5"
                class="community-card card-item">

                <i class="fa-regular fa-heart"></i>

                <h5>Vínculo Familiar</h5>

            </a>

        </div>




        <!-- DISCIPLINA -->
        <div class="col-md-4 col-6">

            <a href="foro.php?id=6"
                class="community-card card-item">

                <i class="fa-solid fa-brain"></i>

                <h5>Disciplina Positiva</h5>

            </a>

        </div>




        <!-- EDUCACION -->
        <div class="col-md-6 col-6">

            <a href="foro.php?id=7"
                class="community-card card-item">

                <i class="fa-solid fa-book-open"></i>

                <h5>Educación</h5>

            </a>

        </div>




        <!-- SALUD -->
        <div class="col-md-6 col-6">

            <a href="foro.php?id=8"
               class="community-card card-item"

                <i class="fa-solid fa-heart-pulse"></i>

                <h5>Salud</h5>

            </a>

        </div>

    </div>

</section>

<!-- FOOTER -->
 <!-- FOOTER -->
<footer class="footer">
  <div class="footer-container">
    <div class="footer-logo">
      <img src="../photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" alt="logo">
    </div>
    <div class="footer-content">
      <h2>Contáctanos:</h2>
      <div class="footer-links">
        <div class="footer-column">
          <p>
            <a href="https://www.instagram.com/parently_team" class="footer-link">
              <i class="bi bi-instagram"></i> Instagram
            </a>
          </p>
          <p>
            <a href="https://whatsapp.com/channel/0029VbD4Q1CEawdpYOZHis1g" class="footer-link">
              <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
          </p>
        </div>
        <div class="footer-column">
          <p>
            <a href="mailto:contacto@parently.com" class="footer-link">
              <i class="bi bi-envelope"></i> Correo
            </a>
          </p>
          <p>
            <a href="https://www.facebook.com/parently" class="footer-link">
              <i class="bi bi-facebook"></i> Facebook
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

  const input = document.querySelector('input[name="busqueda"]');
  const cards = document.querySelectorAll('.community-card');
  const noResults = document.createElement("p");

  noResults.id = "no-results";
  noResults.style.textAlign = "center";
  noResults.style.marginTop = "20px";
  noResults.style.display = "none";
  noResults.innerText = "No se encontraron resultados";

  document.querySelector(".row").after(noResults);

  input.addEventListener("input", function () {

    const val = this.value.toLowerCase();
    let visible = 0;

    cards.forEach(card => {
      const text = card.innerText.toLowerCase();

      if (text.includes(val)) {
        card.closest(".col-md-4, .col-md-6").style.display = "";
        visible++;
      } else {
        card.closest(".col-md-4, .col-md-6").style.display = "none";
      }
    });

    noResults.style.display = visible === 0 ? "block" : "none";
  });

});
</script>


</body>
</html>