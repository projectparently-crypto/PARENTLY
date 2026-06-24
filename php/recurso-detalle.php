<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
include 'get_recursos.php';

// Obtener ID del recurso
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    header("Location: recursos.php");
    exit();
}

// Obtener recurso completo
$recurso = getRecursoById($id);

if (!$recurso) {
    header("Location: recursos.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recurso['titulo']); ?> - Parently</title>
    <link rel="stylesheet" href="../style/recurso-detalle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
     <a class="navbar-brand d-flex align-items-center" href="../index.php">
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

<!-- BREADCRUMB -->
<nav aria-label="breadcrumb" class="breadcrumb-section">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../index.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="recursos.php">Recursos</a></li>
      <li class="breadcrumb-item active"><?php echo htmlspecialchars($recurso['titulo']); ?></li>
    </ol>
  </div>
</nav>

<!-- HEADER CON IMAGEN Y CATEGORÍA -->
<div class="recurso-header">
  <div class="header-content">
    <div class="header-image">
      <img src="<?php echo htmlspecialchars($recurso['imagen']); ?>" alt="<?php echo htmlspecialchars($recurso['titulo']); ?>" class="img-fluid">
      <div class="category-badge">
        <?php echo htmlspecialchars($recurso['categoria']); ?>
      </div>
    </div>
  </div>
</div>

<!-- CONTENIDO PRINCIPAL -->
<div class="container recurso-container">
  <div class="row">
    <!-- COLUMNA IZQUIERDA - CONTENIDO -->
    <div class="col-lg-8">
      <!-- TÍTULO Y META INFO -->
      <div class="recurso-header-info">
        <h1 class="recurso-titulo"><?php echo htmlspecialchars($recurso['titulo']); ?></h1>
        
        <div class="recurso-meta">
          <span class="meta-item">
            <i class="bi bi-tag"></i>
            <strong>Categoría:</strong> <?php echo htmlspecialchars($recurso['categoria']); ?>
          </span>
          <span class="meta-item">
            <i class="bi bi-calendar"></i>
            <strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($recurso['fecha_creacion'])); ?>
          </span>
        </div>
      </div>

      <!-- DESCRIPCIÓN CORTA -->
      <div class="recurso-intro">
        <p class="intro-text">
          <?php echo htmlspecialchars($recurso['descripcion']); ?>
        </p>
      </div>

      <!-- CONTENIDO LARGO -->
      <div class="recurso-contenido">
        <h2>Más información</h2>
        <div class="contenido-body">
          <?php if (!empty($recurso['contenido_largo'])): ?>
            <p><?php echo nl2br(htmlspecialchars($recurso['contenido_largo'])); ?></p>
          <?php else: ?>
            <p>Contenido detallado disponible próximamente.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- SECCIONES ADICIONALES -->
      <div class="recurso-sections">
        <!-- Puntos destacados -->
        <div class="section-box destacados-section">
          <h3><i class="bi bi-star"></i> Puntos destacados</h3>
          <ul class="puntos-lista">
            <li>Información confiable y verificada</li>
            <li>Diseñado para padres y cuidadores</li>
            <li>Fácil de entender y aplicar</li>
            <li>Actualizado periódicamente</li>
          </ul>
        </div>

        <!-- Archivos disponibles -->
        <div class="section-box archivos-section">
          <h3><i class="bi bi-download"></i> Archivos disponibles para descargar</h3>
          <div class="archivos-grid">
            <a href="#" class="archivo-card">
              <div class="archivo-icon">
                <i class="bi bi-file-pdf"></i>
              </div>
              <div class="archivo-info">
                <p class="archivo-nombre">Guía PDF</p>
                <p class="archivo-peso">2.4 MB</p>
              </div>
              <i class="bi bi-download archivo-btn"></i>
            </a>
            <a href="#" class="archivo-card">
              <div class="archivo-icon">
                <i class="bi bi-file-word"></i>
              </div>
              <div class="archivo-info">
                <p class="archivo-nombre">Documento Word</p>
                <p class="archivo-peso">1.8 MB</p>
              </div>
              <i class="bi bi-download archivo-btn"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- COLUMNA DERECHA - SIDEBAR -->
    <div class="col-lg-4">
      <!-- CAJA DE INFORMACIÓN -->
      <div class="info-sidebar">
        <div class="info-card">
          <h3>Información del recurso</h3>
          
          <div class="info-item">
            <span class="info-label">Tipo:</span>
            <span class="info-value"><?php echo htmlspecialchars($recurso['tipo']); ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">Categoría:</span>
            <span class="info-value"><?php echo htmlspecialchars($recurso['categoria']); ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">Para etapa:</span>
            <span class="info-value"><?php echo htmlspecialchars($recurso['etapa']); ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">Publicado:</span>
            <span class="info-value"><?php echo date('d \d\e F \d\e Y', strtotime($recurso['fecha_creacion'])); ?></span>
          </div>

          <button class="btn btn-compartir">
            <i class="bi bi-share"></i> Compartir
          </button>
        </div>

        <!-- CAJA DE LLAMADA A ACCIÓN -->
        <div class="cta-card">
          <h3>¿Te fue útil?</h3>
          <p>Comparte este recurso con otros padres que puedan beneficiarse.</p>
          <div class="cta-buttons">
            <button class="btn btn-cta-primary">
              <i class="bi bi-heart"></i> Me gusta
            </button>
            <button class="btn btn-cta-secondary">
              <i class="bi bi-bookmark"></i> Guardar
            </button>
          </div>
        </div>

        <!-- OTROS RECURSOS RELACIONADOS -->
        <div class="related-resources">
          <h3>Recursos relacionados</h3>
          <div class="related-item">
            <img src="../photos/familia.jpg" alt="Relacionado">
            <h4>Otro recurso importante</h4>
            <a href="#">Ver más →</a>
          </div>
          <div class="related-item">
            <img src="../photos/familia.jpg" alt="Relacionado">
            <h4>Guía complementaria</h4>
            <a href="#">Ver más →</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- VOLVER A RECURSOS -->
<div class="volver-section">
  <div class="container">
    <a href="recursos.php" class="btn-volver">
      <i class="bi bi-arrow-left"></i> Volver a Recursos
    </a>
  </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
