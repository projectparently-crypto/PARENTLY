<?php session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
include 'get_guias.php';

// Obtener ID de la guía
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    header("Location: recursos.php");
    exit();
}

// Obtener guía completa
$guia = getGuiaById($id);

if (!$guia) {
    header("Location: recursos.php");
    exit();
}

// Obtener guías relacionadas (misma categoría)
$guiasRelacionadas = getGuiasPorCategoria($guia['categoria']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($guia['titulo']); ?> - Parently</title>
    <link rel="stylesheet" href="../style/recurso-detalle.css">
    <link rel="stylesheet" href="../style/guia-detalle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="shortcut icon" href="photos/favicon.ico" type="image/x-icon">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
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
           <a class="nav-link" href="../actividades.php">Actividades</a>
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
<div class="breadcrumb-section">
  <div class="container-fluid">
    <nav aria-label="breadcrumb" class="px-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        <li class="breadcrumb-item"><a href="recursos.php">Recursos</a></li>
        <li class="breadcrumb-item active"><?php echo htmlspecialchars($guia['titulo']); ?></li>
      </ol>
    </nav>
  </div>
</div>

<!-- HEADER CON IMAGEN -->
<div class="recurso-header">
  <div class="header-image">
    <img src="<?php echo htmlspecialchars($guia['imagen']); ?>" alt="<?php echo htmlspecialchars($guia['titulo']); ?>">
    <span class="category-badge">
      <i class="bi bi-book"></i> <?php echo htmlspecialchars($guia['tipo_guia']); ?>
    </span>
  </div>
</div>

<!-- CONTENIDO PRINCIPAL -->
<div class="recurso-container">
  <div class="row">
    <!-- CONTENIDO PRINCIPAL -->
    <div class="col-lg-8">
      <!-- HEADER INFO -->
      <div class="recurso-header-info">
        <h1 class="recurso-titulo"><?php echo htmlspecialchars($guia['titulo']); ?></h1>
        
        <div class="recurso-meta">
          <div class="meta-item">
            <i class="bi bi-calendar3"></i>
            <?php echo date('d/m/Y', strtotime($guia['fecha_creacion'])); ?>
          </div>
          <div class="meta-item">
            <i class="bi bi-tag"></i>
            <?php echo htmlspecialchars($guia['categoria']); ?>
          </div>
          <div class="meta-item">
            <i class="bi bi-person"></i>
            Por: <?php echo htmlspecialchars($guia['autor']); ?>
          </div>
          <?php if (!empty($guia['etapa'])): ?>
            <div class="meta-item">
              <i class="bi bi-brightness-high"></i>
              Etapa: <?php echo htmlspecialchars($guia['etapa']); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- INTRO -->
      <div class="recurso-intro">
        <p class="intro-text">
          <?php echo htmlspecialchars($guia['descripcion']); ?>
        </p>
      </div>

      <!-- CONTENIDO LARGO -->
      <div class="recurso-contenido">
        <h2>Contenido Completo</h2>
        <div class="contenido-body">
          <?php echo nl2br(htmlspecialchars($guia['contenido_largo'])); ?>
        </div>
      </div>

      <!-- SECCIONES ADICIONALES -->
      <div class="recurso-sections">
        <!-- CONSEJOS PRÁCTICOS -->
        <div class="section-box">
          <h3>
            <i class="bi bi-lightbulb"></i> Consejos Prácticos
          </h3>
          <ul class="puntos-lista">
            <li>Lee esta guía con calma y toma notas de los puntos importantes</li>
            <li>Comparte los aprendizajes con otros padres de tu comunidad</li>
            <li>Aplica gradualmente los consejos en tu día a día</li>
            <li>No dudes en consultar a especialistas si lo necesitas</li>
            <li>Recuerda que cada familia es única y especial</li>
          </ul>
        </div>

        <!-- DESCARGABLES -->
        <?php if (!empty($guia['enlace_descarga'])): ?>
          <div class="section-box">
            <h3>
              <i class="bi bi-download"></i> Descargas
            </h3>
            <div class="archivos-grid">
              <a href="<?php echo htmlspecialchars($guia['enlace_descarga']); ?>" download class="archivo-card">
                <div class="archivo-icon">
                  <i class="bi bi-file-pdf"></i>
                </div>
                <div class="archivo-info">
                  <div class="archivo-nombre">Descargar Guía</div>
                  <div class="archivo-peso">Formato PDF</div>
                </div>
                <div class="archivo-btn">
                  <i class="bi bi-arrow-down"></i>
                </div>
              </a>
            </div>
          </div>
        <?php endif; ?>

        <!-- REFLEXIÓN -->
        <div class="section-box guia-reflexion">
          <h3>
            <i class="bi bi-chat-dots"></i> Para Reflexionar
          </h3>
          <p class="reflexion-text">
            Esta guía te proporciona herramientas valiosas para fortalecer tu rol como padre/madre. 
            Recuerda que no existe una forma "perfecta" de criar. Lo importante es que actúes con amor, 
            paciencia y disposición a aprender constantemente.
          </p>
        </div>
      </div>

    </div>

    <!-- SIDEBAR -->
    <div class="col-lg-4">
      <div class="info-sidebar">
        
        <!-- INFO CARD -->
        <div class="info-card">
          <h3><i class="bi bi-info-circle"></i> Información</h3>
          
          <div class="info-item">
            <span class="info-label">Tipo de Guía</span>
            <span class="info-value"><?php echo htmlspecialchars($guia['tipo_guia']); ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">Categoría</span>
            <span class="info-value"><?php echo htmlspecialchars($guia['categoria']); ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">Autor</span>
            <span class="info-value"><?php echo htmlspecialchars($guia['autor']); ?></span>
          </div>

          <?php if (!empty($guia['etapa'])): ?>
            <div class="info-item">
              <span class="info-label">Etapa Recomendada</span>
              <span class="info-value"><?php echo htmlspecialchars($guia['etapa']); ?></span>
            </div>
          <?php endif; ?>

          <div class="info-item">
            <span class="info-label">Publicado</span>
            <span class="info-value"><?php echo date('d/m/Y', strtotime($guia['fecha_creacion'])); ?></span>
          </div>

          <button class="btn-compartir" onclick="compartirGuia()">
            <i class="bi bi-share"></i> Compartir
          </button>
        </div>

        <!-- CTA CARD -->
        <div class="cta-card">
          <h3><i class="bi bi-star"></i> ¿Te fue útil?</h3>
          <p>Comparte esta guía con otros padres y ayuda a crear una comunidad más fuerte.</p>
          <div class="cta-buttons">
            <button class="btn-cta-primary" onclick="window.location.href='comunidades.php'">
              <i class="bi bi-people"></i> Ir a Comunidades
            </button>
            <button class="btn-cta-secondary" onclick="window.location.href='recursos.php'">
              <i class="bi bi-arrow-left"></i> Ver Más Recursos
            </button>
          </div>
        </div>

        <!-- GUÍAS RELACIONADAS -->
        <?php if ($guiasRelacionadas && $guiasRelacionadas->num_rows > 0): ?>
          <div class="related-resources">
            <h3><i class="bi bi-bookmark"></i> Guías Relacionadas</h3>
            
            <?php $contador = 0; ?>
            <?php while($item = $guiasRelacionadas->fetch_assoc()): ?>
              <?php if($contador < 3 && $item['id'] != $guia['id']): ?>
                <div class="related-item">
                  <img src="<?php echo htmlspecialchars($item['imagen']); ?>" alt="<?php echo htmlspecialchars($item['titulo']); ?>">
                  <h4><?php echo htmlspecialchars($item['titulo']); ?></h4>
                  <a href="guia-detalle.php?id=<?php echo $item['id']; ?>">Leer más →</a>
                </div>
                <?php $contador++; ?>
              <?php endif; ?>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>

  </div>
</div>

<!-- VOLVER -->
<div class="volver-section">
  <a href="recursos.php" class="btn-volver">
    <i class="bi bi-arrow-left"></i> Volver a Recursos
  </a>
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

<script>
  function compartirGuia() {
    const url = window.location.href;
    const titulo = '<?php echo htmlspecialchars($guia['titulo']); ?>';
    
    if (navigator.share) {
      navigator.share({
        title: titulo,
        text: 'Mira esta guía para padres en Parently',
        url: url
      });
    } else {
      // Fallback: copiar al portapapeles
      navigator.clipboard.writeText(url);
      alert('Link copiado al portapapeles');
    }
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
