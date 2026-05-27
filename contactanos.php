<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Parently</title>
 
<link rel="stylesheet" href="homepage.css">
 
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
 
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
 
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 
<style>
 
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}
 
/* =========================
   BODY
========================= */
 
body{
    background-color: #f5e8d9;
    margin: 0;
    padding: 0;
}
 
/* =========================
   NAVBAR
========================= */
 
.navbar{
    background-color: #FE7AA1;
    padding: 15px 40px;
    width: 100%;
}
 
.navbar-brand{
    color: white !important;
    font-size: 28px;
    font-weight: bold;
}
 
.nav-link{
    color: white !important;
    font-weight: bold;
    font-size: 17px;
}
 
.nav-link:hover{
    color: #ffe4ec !important;
}
 
/* =========================
   CONTACTO
========================= */
 
.contacto{
    width: 100%;
    padding: 40px 60px;
}
 
/* PARTE SUPERIOR */
 
.contacto-header{
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px;
 
    background-color: white;
 
    padding: 30px;
 
    border-radius: 25px;
 
    margin-bottom: 40px;
 
    box-shadow: 0px 4px 10px rgba(0,0,0,0.08);
}
 
.texto h1{
    color: #c2185b;
    font-size: 38px;
    margin-bottom: 10px;
}
 
.texto p{
    font-size: 17px;
    color: #333;
    line-height: 1.5;
    max-width: 300px;
}
 
/* IMAGEN */
 
.imagen img{
    width: 180px;
}
 
/* CONTENEDOR */
 
.contenedor-contacto{
    display: flex;
    justify-content: space-between;
    gap: 30px;
}
 
/* FORMULARIO */
 
.formulario{
    width: 55%;
    background-color: #FFBDC8;
    padding: 25px;
    border-radius: 20px;
}
 
.formulario h2{
    color: #c2185b;
    margin-bottom: 20px;
    font-size: 25px;
}
 
.formulario label{
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 16px;
}
 
.formulario input,
.formulario textarea{
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    outline: none;
    font-size: 14px;
}
 
.formulario textarea{
    height: 120px;
    resize: none;
}
 
.formulario button{
    width: 100%;
    padding: 14px;
    margin-top: 20px;
    border: none;
    border-radius: 12px;
    background-color: #FE7AA1;
    color: white;
    font-size: 18px;
    cursor: pointer;
}
 
/* INFO CONTACTO */
 
.info-contacto{
    width: 40%;
    background-color: #FFBDC8;
    padding: 25px;
    border-radius: 20px;
}
 
.info-contacto h2{
    color: #c2185b;
    margin-bottom: 20px;
    font-size: 24px;
}
 
/* TARJETAS */
 
.card{
    background-color: #FE7AA1;
    color: white;
    padding: 18px;
    border-radius: 15px;
    margin-bottom: 20px;
}
 
.card h3{
    margin-bottom: 5px;
    font-size: 18px;
}
 
.card p{
    font-size: 14px;
}
 
/* =========================
   COMENTARIOS
========================= */
 
.comentarios{
    margin: 50px 60px;
    background-color: #EFA8CA;
    padding: 25px;
    border-radius: 20px;
}
 
/* CAJA */
 
.comentarios-box{
    background-color: #FFBDC8;
    padding: 30px;
    border-radius: 15px;
}
 
/* TITULO */
 
.comentarios-box h2{
    text-align: center;
    color: #9b004f;
    font-size: 35px;
    margin-bottom: 20px;
}
 
/* ESTRELLAS */
 
.estrellas{
    text-align: center;
    font-size: 45px;
    margin-bottom: 20px;
}
 
/* TEXTAREA */
 
.comentarios-box textarea{
    width: 100%;
    height: 140px;
    border: none;
    border-radius: 15px;
    padding: 18px;
    font-size: 15px;
    resize: none;
    outline: none;
    background-color: #f8d7de;
}
 
/* FOOTER */
 
.comentario-footer{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}
 
/* OSITO */
 
.comentario-footer img{
    width: 90px;
}
 
/* BOTON */
 
.comentario-footer button{
    background-color: #FE7AA1;
    color: white;
    border: none;
    padding: 14px 25px;
    border-radius: 12px;
    font-size: 18px;
    cursor: pointer;
}
 
/* SEGURIDAD */
 
.seguridad{
    margin-top: 30px;
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    color: black;
}
 
/* =========================
   RESPONSIVE
========================= */
 
@media(max-width: 900px){
 
    .contacto{
        padding: 20px;
    }
 
    .comentarios{
        margin: 20px;
    }
 
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
 
    .comentario-footer{
        flex-direction: column;
        gap: 15px;
    }
 
    .comentario-footer button{
        width: 100%;
    }
 
}
 
</style>
</head>
 
<body>
 
<!-- NAVBAR -->
 
<nav class="navbar navbar-expand-lg">
 
    <div class="container-fluid">
 
        <a class="navbar-brand d-flex align-items-center" href="index.php">
 
            <img src="photos/ChatGPT_Image_May_3__2026__07_29_09_PM-removebg-preview.png"
                 width="40"
                 class="me-2">
 
            Parently
 
        </a>
 
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
 
            <span class="navbar-toggler-icon"></span>
 
        </button>
 
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
 
            <ul class="navbar-nav mx-auto gap-2">
 
                <li class="nav-item">
                    <a class="nav-link active" href="recursos.php">Recursos</a>
                </li>
 
                <li class="nav-item">
                    <a class="nav-link" href="#">Actividades</a>
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
 
                <?php if (isset($_SESSION['usuario_nombre'])): ?>
 
                    <div class="d-flex align-items-center gap-2">
 
                        <div style="width: 45px;
                                    height: 45px;
                                    background: linear-gradient(135deg, #ff6fa5, #ff4081);
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    color: white;
                                    font-weight: bold;
                                    font-size: 18px;
                                    cursor: pointer;"
                             onclick="window.location.href='perfil.php'">
 
                            <?php echo strtoupper(substr($_SESSION['usuario_nombre'], 0, 1)); ?>
 
                        </div>
 
                        <span style="color: white;
                                     font-weight: bold;
                                     cursor: pointer;"
                              onclick="window.location.href='perfil.php'">
 
                            <?php echo $_SESSION['usuario_nombre']; ?>
 
                        </span>
 
                    </div>
 
                    <a href="logout.php" class="btn btn-danger btn-sm">
                        Cerrar Sesión
                    </a>
 
                <?php else: ?>
 
                    <a href="login.php" class="btn btn-outline-light">
                        Iniciar Sesión
                    </a>
 
                    <a href="registro.php" class="btn btn-light">
                        Registrarse
                    </a>
 
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
 
            <img src="photos/contactanos/familia.png" alt="Familia">
 
        </div>
 
    </div>
 
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
 
        <!-- INFO -->
 
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
 
</section>
 
<!-- =========================
     COMENTARIOS
========================= -->
 
<section class="comentarios">
 
    <div class="comentarios-box">
 
        <h2>¿Te ha sido útil Parently?</h2>
 
        <div class="estrellas">
            ⭐ ⭐ ⭐ ⭐ ⭐
        </div>
 
        <textarea placeholder="Déjanos tus comentarios..."></textarea>

        <div class="comentario-footer">
 
            <img src="photos/contactanos/osito.png" alt="Osito">
 
            <button>Enviar comentario</button>
 
        </div>
 
    </div>
 
    <div class="seguridad">
        🤍 Tu información es segura con nosotros
    </div>
 
</section>
 
<!-- Bootstrap JS -->
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
 
</body>
</html>