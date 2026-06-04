<?php session_start(); 
include 'db.php';
include 'get_recursos.php';

// Obtener datos
$recursosMasVistos = getRecursosMasVistos(2);
$consejos = getConsejos(4);
$etapas = getEtapas();
$guias = getGuias(4);
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
 
<!-- HEADER -->
<div class="recursos-header">
  <h1>🎓 RECURSOS</h1>
  <p style="font-size: 18px; margin: 0;">Portal de la Crianza</p>
</div>

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
    <p style="text-align: center; font-style: italic; color: #D94571; margin-top: 25px;">
      <strong>Todo en un solo lugar.</strong>
    </p>
  </div>
</div>

<!-- LO MÁS VISTO -->
<h2 class="section-title">Lo más visto del mes</h2>

<div class="cards-grid">
  <?php while($recurso = $recursosMasVistos->fetch_assoc()): ?>
    <div class="card-item">
      <div class="card-img-container">
        <img src="<?php echo htmlspecialchars($recurso['imagen']); ?>" alt="<?php echo htmlspecialchars($recurso['titulo']); ?>">
      </div>
      <div class="card-item-body">
        <h3><?php echo htmlspecialchars($recurso['titulo']); ?></h3>
        <p><?php echo substr(htmlspecialchars($recurso['descripcion']), 0, 100) . '...'; ?></p>
        <a href="recurso-detalle.php?id=<?php echo $recurso['id']; ?>" class="card-item-link">Seguir leyendo aquí ➜</a>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<!-- CONSEJOS PARA TI EN EL DÍA A DÍA -->
<h2 class="section-title">Consejos para ti en el día a día</h2>

<div class="consejos-grid">
  <?php while($consejo = $consejos->fetch_assoc()): ?>
    <div class="consejo-card">
      <div class="card-img-container">
        <img src="<?php echo htmlspecialchars($consejo['imagen']); ?>" alt="<?php echo htmlspecialchars($consejo['titulo']); ?>">
      </div>
      <div class="consejo-body">
        <h4><?php echo htmlspecialchars($consejo['titulo']); ?></h4>
        <p><?php echo htmlspecialchars($consejo['descripcion']); ?></p>
        <a href="recurso-detalle.php?id=<?php echo $consejo['id']; ?>" class="card-item-link">Leer más ➜</a>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<!-- ETAPAS -->
<div class="etapas-section">
  <h3>¿Qué estás buscando?</h3>
  <p style="color: #D94571; font-size: 16px; margin-bottom: 30px;">Ingresá a la etapa de tu interés:</p>
  
  <div class="etapas-buttons">
    <?php while($etapa = $etapas->fetch_assoc()): ?>
      <button class="etapa-btn" onclick="window.location.href='recursos-etapa.php?etapa=<?php echo urlencode($etapa['slug']); ?>'">
        <div class="card-img-container">
          <img src="<?php echo htmlspecialchars($etapa['imagen']); ?>" alt="<?php echo htmlspecialchars($etapa['nombre']); ?>">
        </div>
        <?php echo htmlspecialchars($etapa['nombre']); ?>
      </button>
    <?php endwhile; ?>
  </div>
</div>

<!-- GUÍAS PARA FAMILIAS -->
<h2 class="section-title">Guías para familias</h2>

<div class="guias-grid">
  <?php while($guia = $guias->fetch_assoc()): ?>
    <div class="guia-card">
      <div class="card-img-container">
        <img src="<?php echo htmlspecialchars($guia['imagen']); ?>" alt="<?php echo htmlspecialchars($guia['titulo']); ?>">
      </div>
      <div class="guia-body">
        <h5><?php echo htmlspecialchars($guia['titulo']); ?></h5>
        <p><?php echo htmlspecialchars($guia['descripcion']); ?></p>
        <a href="recurso-detalle.php?id=<?php echo $guia['id']; ?>" class="card-item-link">Leer más ➜</a>
      </div>
    </div>
  <?php endwhile; ?>
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