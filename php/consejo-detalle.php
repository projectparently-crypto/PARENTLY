<?php 
session_start(); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
include 'get_consejos.php';

// Obtener ID del consejo
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    header("Location: recursos.php");
    exit();
}

// Obtener consejo completo de la BD
$consejo = getConsejoDetalleById($id);

if (!$consejo) {
    header("Location: recursos.php");
    exit();
}

// Obtener otros consejos relacionados (mismo tipo o categoría)
$consejosRelacionados = getConsejosPorCategoria($consejo['categoria']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($consejo['titulo']); ?> - Parently</title>
    <link rel="stylesheet" href="../style/recurso-detalle.css">
        <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/consejo-detalle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../photos/favicon.ico">
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
<nav aria-label="breadcrumb" class="breadcrumb-section">
  <div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="recursos.php">Recursos</a></li>
      <li class="breadcrumb-item"><a href="recursos.php">Consejos del día</a></li>
      <li class="breadcrumb-item active"><?php echo htmlspecialchars(substr($consejo['titulo'], 0, 50)); ?></li>
    </ol>
  </div>
</nav>

<!-- HEADER CON IMAGEN Y CATEGORÍA -->
<div class="recurso-header">
  <div class="header-content">
    <div class="header-image">
      <img src="<?php echo htmlspecialchars($consejo['imagen']); ?>" alt="<?php echo htmlspecialchars($consejo['titulo']); ?>" class="img-fluid">
      <div class="category-badge">
        💡 Consejo del Día
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
        <div class="categoria-label">
          <?php echo htmlspecialchars($consejo['categoria']); ?>
        </div>
        
        <h1 class="recurso-titulo"><?php echo htmlspecialchars($consejo['titulo']); ?></h1>
        
        <div class="tiempo-lectura">
          <i class="bi bi-clock"></i>
          <span><?php echo intval($consejo['tiempo_lectura']); ?> min de lectura</span>
        </div>
        
        <div class="recurso-meta">
          <span class="meta-item">
            <i class="bi bi-calendar"></i>
            <strong>Publicado:</strong> <?php echo date('d/m/Y', strtotime($consejo['fecha_creacion'])); ?>
          </span>
          <span class="meta-item">
            <i class="bi bi-tag"></i>
            <strong>Tipo:</strong> <?php echo htmlspecialchars(ucfirst($consejo['tipo_consejo'])); ?>
          </span>
        </div>
      </div>

      <!-- ETAPA RECOMENDADA -->
      <?php if (!empty($consejo['etapa'])): ?>
        <div class="etapa-info">
          <strong><i class="bi bi-info-circle"></i> Recomendado para:</strong>
          <span><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $consejo['etapa']))); ?></span>
        </div>
      <?php endif; ?>

      <!-- DESCRIPCIÓN CORTA -->
      <div class="recurso-intro">
        <p class="intro-text">
          <?php echo htmlspecialchars($consejo['descripcion']); ?>
        </p>
      </div>

      <!-- CONTENIDO LARGO (CONSEJO COMPLETO) -->
      <div class="recurso-contenido">
        <h2>Consejo Completo</h2>
        <div class="contenido-consejo">
          <?php if (!empty($consejo['contenido_largo'])): ?>
            <?php echo nl2br(htmlspecialchars($consejo['contenido_largo'])); ?>
          <?php else: ?>
            <p>Para obtener más detalles sobre este consejo, te recomendamos:</p>
            <ul>
              <li>Consultar con un especialista en desarrollo infantil</li>
              <li>Visitar nuestra sección de guías para familias</li>
              <li>Participar en nuestra comunidad de padres</li>
            </ul>
          <?php endif; ?>
        </div>
      </div>

      <!-- SECCIONES ADICIONALES -->
      <div class="recurso-sections">
        <!-- Puntos destacados -->
        <div class="section-box destacados-section">
          <h3><i class="bi bi-star"></i> Puntos Clave</h3>
          <ul class="puntos-lista">
            <li>Consejo basado en evidencia científica</li>
            <li>Fácil de implementar en tu día a día</li>
            <li>Adaptable a diferentes edades y situaciones</li>
            <li>Ayuda a mejorar la relación con tus hijos</li>
          </ul>
        </div>

        <!-- Información adicional -->
        <div class="section-box archivos-section">
          <h3><i class="bi bi-lightbulb"></i> ¿Por qué es importante?</h3>
          <div class="info-text">
            <p>Este consejo es parte de nuestra misión de acompañarte en cada etapa de la crianza. La información que compartimos está seleccionada cuidadosamente para ayudarte a tomar mejores decisiones y disfrutar más del proceso de criar a tus hijos.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- COLUMNA DERECHA - SIDEBAR -->
    <div class="col-lg-4">
      <!-- CAJA DE INFORMACIÓN -->
      <div class="info-sidebar">
        <div class="info-card">
          <h3>📋 Información del Consejo</h3>
          
          <div class="info-item">
            <span class="info-label">Tipo de contenido:</span>
            <span class="info-value">
              <span class="consejo-tipo-badge consejo-tipo-<?php echo htmlspecialchars($consejo['tipo_consejo']); ?>">
                <?php echo htmlspecialchars(ucfirst($consejo['tipo_consejo'])); ?>
              </span>
            </span>
          </div>

          <div class="info-item">
            <span class="info-label">Categoría:</span>
            <span class="info-value"><?php echo htmlspecialchars($consejo['categoria']); ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">Para etapa:</span>
            <span class="info-value"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $consejo['etapa']))); ?></span>
          </div>

          <div class="info-item">
            <span class="info-label">Tiempo de lectura:</span>
            <span class="info-value"><?php echo intval($consejo['tiempo_lectura']); ?> minutos</span>
          </div>

          <div class="info-item">
            <span class="info-label">Fecha de publicación:</span>
            <span class="info-value"><?php echo date('d \d\e F \d\e Y', strtotime($consejo['fecha_creacion'])); ?></span>
          </div>

          <button class="btn btn-compartir">
            <i class="bi bi-share"></i> Compartir
          </button>
        </div>

        <!-- CAJA DE LLAMADA A ACCIÓN -->
        <div class="cta-card">
          <h3>¿Te fue útil?</h3>
          <p>Comparte este consejo con otros padres que puedan beneficiarse de esta información.</p>
          <div class="cta-buttons">
            <button class="btn btn-cta-primary" onclick="alert('¡Gracias por tu me gusta!')">
              <i class="bi bi-heart"></i> Me gusta
            </button>
            <button class="btn btn-cta-secondary" onclick="alert('Consejo guardado en tus favoritos')">
              <i class="bi bi-bookmark"></i> Guardar
            </button>
          </div>
        </div>

        <!-- OTROS CONSEJOS RELACIONADOS -->
        <div class="related-resources">
          <h3>🔗 Consejos Relacionados</h3>
          <div class="consejos-relacionados-grid">
            <?php 
            $contador = 0;
            if ($consejosRelacionados && $consejosRelacionados->num_rows > 0): 
              while($relac = $consejosRelacionados->fetch_assoc()):
                if ($relac['id'] != $consejo['id'] && $contador < 3):
            ?>
              <a href="consejo-detalle.php?id=<?php echo $relac['id']; ?>" class="consejo-relacionado-card">
                <img src="<?php echo htmlspecialchars($relac['imagen']); ?>" alt="<?php echo htmlspecialchars($relac['titulo']); ?>" class="consejo-relacionado-img">
                <div class="consejo-relacionado-body">
                  <h5><?php echo htmlspecialchars(substr($relac['titulo'], 0, 50)); ?></h5>
                  <a href="consejo-detalle.php?id=<?php echo $relac['id']; ?>" class="consejo-relacionado-link">
                    Ver más <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </a>
            <?php 
                  $contador++;
                endif;
              endwhile;
            endif; 
            ?>
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
            <a href="https://www.instagram.com/parently_team?igsh=d251dXlzcnF4anp5" class="footer-link">
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
