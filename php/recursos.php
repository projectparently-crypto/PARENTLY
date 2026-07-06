<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
include 'get_recursos.php';
include 'get_consejos.php';
include 'get_guias.php';

// Obtener datos
$recursosMasVistos = getRecursosMasVistos(2);
$consejos = getConsejosDelDia(4);
$etapas = getEtapas();
$guias = getGuiasParaFamilias(4);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos - Parently</title>
    <link rel="stylesheet" href="../style/recursos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

   <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg ">
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
 


<!-- PORTAL SECTION -->
<div class="portal-section">
  <div class="portal-image">
    <img src="../photos/familia.jpg" alt="Familia feliz">
  </div>
  <div class="portal-content">
    <h2>Portal de la Crianza</h2>
    <p>
      <strong>Ayudando a madres, padres y cuidadores a darles a niñas, niños y adolescentes el mejor comienzo en la vida.</strong>
    </p>
    <p>
      Todos queremos lo mejor para nuestros hijos e hijas, pero no siempre es tarea fácil.
    </p>
    <p>
      <strong>Por qué PARENTLY ofrece ideas, consejos de expertos e información confiable</strong>
      para acompañar a las familias en cada etapa del crecimiento de niñas, niños y adolescentes.
    </p>
    <p>
      <strong>Encontrá contenidos, recursos y herramientas</strong> sobre embarazo, primeros años, etapa escolar y adolescencia.
    </p>
    <p>
      <strong>Todo en un solo lugar.</strong>
    </p>
  </div>
</div>

<!-- LO MÁS VISTO -->
<h2 class="section-title">Lo más visto del mes</h2>

<div class="cards-grid">
<?php if($recursosMasVistos && $recursosMasVistos->num_rows > 0): ?>
    <?php while($recurso = $recursosMasVistos->fetch_assoc()): ?>
        <div class="card-item">
            <div class="card-img-container">
                <img src="<?php echo htmlspecialchars($recurso['imagen']); ?>" alt="<?php echo htmlspecialchars($recurso['titulo']); ?>">
            </div>

            <div class="card-item-body">
                <h3><?php echo htmlspecialchars($recurso['titulo']); ?></h3>

                <p>
                    <?php echo substr(htmlspecialchars($recurso['descripcion']),0,100).'...'; ?>
                </p>

                <a href="recurso-detalle.php?id=<?php echo $recurso['id']; ?>" class="card-item-link">
                    Seguir leyendo aquí ➜
                </a>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p class="text-center">No hay recursos disponibles</p>
<?php endif; ?>
</div>

<!-- CONSEJOS PARA TI EN EL DÍA A DÍA -->
<h2 class="section-title">Consejos para ti en el día a día </h2>

<div class="consejos-grid">
  <?php if($consejos && $consejos->num_rows > 0): ?>
    <?php while($consejo = $consejos->fetch_assoc()): ?>
      <div class="consejo-card">
        <div class="card-img-container">
          <img src="<?php echo htmlspecialchars($consejo['imagen']); ?>" alt="<?php echo htmlspecialchars($consejo['titulo']); ?>">
        </div>
        <div class="consejo-body">
          <h4><?php echo htmlspecialchars($consejo['titulo']); ?></h4>
          <p><?php echo htmlspecialchars($consejo['descripcion']); ?></p>
          <a href="consejo-detalle.php?id=<?php echo $consejo['id']; ?>" class="card-item-link">Leer más </a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-center" style="color: #D94571; padding: 20px;"><strong>⚠️ No hay consejos disponibles. Agrega consejos desde el panel de admin.</strong></p>
  <?php endif; ?>
</div>

<!-- GUÍAS PARA FAMILIAS -->
<h2 class="section-title">Guías para familias</h2>

<div class="guias-grid">
  <?php if($guias && $guias->num_rows > 0): ?>
    <?php while($guia = $guias->fetch_assoc()): ?>
      <div class="guia-card">
        <div class="card-img-container">
          <img src="<?php echo htmlspecialchars($guia['imagen']); ?>" alt="<?php echo htmlspecialchars($guia['titulo']); ?>">
        </div>
        <div class="guia-body">
          <h5><?php echo htmlspecialchars($guia['titulo']); ?></h5>
          <p><?php echo htmlspecialchars($guia['descripcion']); ?></p>
          <a href="guia-detalle.php?id=<?php echo $guia['id']; ?>" class="card-item-link">Leer más ➜</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-center" style="color: #D94571; padding: 20px;"><strong>⚠️ No hay guías disponibles. Agrega guías desde el panel de admin.</strong></p>
  <?php endif; ?>
</div>

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
            <a href="https://www.instagram.com/parently_team?igsh=d251dXlzcnF4anp5" class="footer-link">
              <i class="bi bi-instagram"></i> Instagram:
            </a>
          </p>
          <p>
            <a href="https://whatsapp.com/channel/0029VbD4Q1CEawdpYOZHis1g" class="footer-link">
              <i class="bi bi-whatsapp"></i> WhatsApp:
            </a>
          </p>
        </div>
        <div class="footer-column">
          <p>
            <a href="mailto:tucorreo@gmail.com" class="footer-link">
              <i class="bi bi-envelope"></i> Correo:
            </a>
          </p>
          <p>
            <a href="https://www.facebook.com/share/g/1CgdV2AhZ4/" class="footer-link">
              <i class="bi bi-facebook"></i> Facebook:
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
