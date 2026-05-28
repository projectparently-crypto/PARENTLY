<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Parently - Foros</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FONT AWESOME -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- CSS -->
  <link rel="stylesheet" href="comunidades.css">
  <style>


/* FORO */
.foro{
  width:100%;
}


/* IMAGEN */
.foro-img{

  width:100%;
  height:420px;

  object-fit:cover;

  border-bottom-left-radius:25px;
  border-bottom-right-radius:25px;

  display:block;
}


/* INFO */
.info-foro{

  background:#FAFAFA;

  padding:30px;

  display:flex;
  justify-content:space-between;
  align-items:center;

  flex-wrap:wrap;
}


/* IZQUIERDA */
.info-left h1{

  font-size:42px;
  font-weight:bold;

  margin-bottom:8px;
}

.info-left p{

  color:gray;
  font-size:17px;
}


/* DERECHA */
.info-right{

  display:flex;
  align-items:center;
  gap:15px;
}


/* LUPA */
.search-icon{

  width:52px;
  height:52px;

  border-radius:50%;

  background:white;

  display:flex;
  justify-content:center;
  align-items:center;

  font-size:20px;

  box-shadow:0 2px 10px rgba(0,0,0,0.1);
}


/* BOTON */
#btnUnirse{

  background:#D94571;

  color:white;

  border:none;

  padding:12px 28px;

  border-radius:14px;

  font-weight:bold;
}


/* TABS */
.tabs{

  width:95%;

  margin:auto;

  margin-top:10px;

  background:#FFBDC8;

  border-radius:18px;

  padding:12px;

  display:flex;
  justify-content:space-around;
}


.tabs button{

  border:none;

  background:transparent;

  padding:10px 20px;

  border-radius:10px;

  font-weight:bold;
}

.tabs button:hover{
  background:white;
}


/* DESTACADO */
.destacado{

  width:95%;

  margin:25px auto;

  background:white;

  border-radius:22px;

  padding:20px;

  display:flex;
  justify-content:space-between;
  align-items:center;

  box-shadow:0 2px 10px rgba(0,0,0,0.08);
}


.destacado-user{

  display:flex;
  align-items:center;
  gap:15px;
}


.destacado-user img{

  width:70px;
  height:70px;

  border-radius:50%;

  object-fit:cover;
}


/* CHAT */
.chat-icon{

  width:50px;
  height:50px;

  border-radius:50%;

  background:#FFD6DE;

  display:flex;
  justify-content:center;
  align-items:center;

  font-size:20px;
}


/* COMENTAR */
.coment-box{

  width:95%;

  margin:auto;

  margin-bottom:20px;

  background:white;

  border-radius:20px;

  padding:18px;

  display:flex;
  gap:10px;
}


.coment-box input{

  flex:1;

  border:none;

  background:#F5F5F5;

  border-radius:12px;

  padding:14px;

  outline:none;
}


.coment-box button{

  background:#D94571;

  color:white;

  border:none;

  border-radius:12px;

  padding:12px 20px;

  font-weight:bold;
}


/* COMENTARIOS */
#comentarios{

  width:95%;
  margin:auto;
}


/* CARTA */
.comentario{

  background:white;

  border-radius:24px;

  padding:20px;

  margin-bottom:20px;

  box-shadow:0 2px 10px rgba(0,0,0,0.08);
}


/* TOP */
.comentario-top{

  background:#FFADAD;

  border-radius:16px;

  padding:15px;

  margin-bottom:15px;
}


/* TEXTO */
.comentario-texto{

  background:#FAFAFA;

  border-radius:14px;

  padding:18px;
}


/* ELIMINAR */
.comentario button{

  margin-top:15px;

  background:#D94571;

  color:white;

  border:none;

  padding:8px 18px;

  border-radius:10px;
}



</style>
</head>

<body>
  <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">

    <!-- Logo + nombre (izquierda) -->
    <a class="navbar-brand d-flex align-items-center" href="comunidades.php">
      <img src="img/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png" width="50" class="me-3">
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


<!-- ================= FORO ================= -->
<div class="foro">

  <!-- IMAGEN GRANDE -->
  <img id="foro-img" class="foro-img">

  <!-- INFO DEL FORO -->
  <div class="info-foro">

    <!-- IZQUIERDA -->
    <div class="info-left">

      <h1 id="foro-titulo"></h1>

      <p>
        <span id="tipo-foro">Público</span> ·
        <span id="miembros">0</span> miembros
      </p>

    </div>

    <!-- DERECHA -->
    <div class="info-right">

      <!-- LUPA -->
      <div class="search-icon">
        <i class="fa fa-search"></i>
      </div>

      <!-- BOTON -->
      <button id="btnUnirse" onclick="unirse()">
        Unirse
      </button>

    </div>

  </div>

  <!-- TABS -->
  <div class="tabs">

    <button>Discusión</button>
    <button>Media</button>
    <button>Miembros</button>
    <button>Sobre</button>

  </div>


  <!-- ================= USUARIO DESTACADO ================= -->
  <div class="destacado">

    <!-- IZQUIERDA -->
    <div class="destacado-user">

      <img src="img/user1.jpg">

      <div>

        <h3>Usuario destacado</h3>

        <p>
          Se unió hace 2 semanas
        </p>

      </div>

    </div>

    <!-- DERECHA -->
    <div class="chat-icon">
      <i class="fa fa-comment"></i>
    </div>

  </div>


  <!-- ================= COMENTAR ================= -->
  <div class="coment-box">

    <input
      id="inputComentario"
      placeholder="Escribe un comentario..."
    >

    <button onclick="publicar()">
      Publicar
    </button>

  </div>


  <!-- ================= COMENTARIOS ================= -->
  <div id="comentarios"></div>

</div>


<script>
let usuario = "<?php echo $_SESSION['usuario_nombre'] ?? 'Invitado'; ?>";
</script>

<script src="script.js?v=2"></script>

</body>
</html>