<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actividades</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background-color: #f4eadc;
        }

        /* NAVBAR */

        nav{
            width: 100%;
            background-color: #f8a8bc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 40px;
        }

        .logo{
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img{
            width: 55px;
        }

        .nav-links{
            display: flex;
            gap: 25px;
        }

        .nav-links a{
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 8px 18px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .nav-links a:hover{
            background-color: white;
            color: #f06292;
        }

        .activo{
            background-color: white;
            color: #f06292 !important;
        }

        /* HERO */

        .hero{
            width: 100%;
            height: 500px;
            background-image: linear-gradient(
                rgba(0,0,0,0.35),
                rgba(0,0,0,0.35)
            ),
            url('https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1600&auto=format&fit=crop');
            
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding-left: 70px;
        }

        .hero-text{
            color: white;
            max-width: 500px;
        }

        .hero-text h1{
            font-size: 55px;
            margin-bottom: 20px;
            line-height: 1.1;
        }

        .hero-text p{
            font-size: 24px;
            line-height: 1.5;
        }

        /* TITULO */

        .titulo{
            text-align: center;
            margin-top: 50px;
            font-size: 55px;
            color: black;
        }

        /* BOTONES EDADES */

        .edades{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 35px;
            margin-bottom: 50px;
        }

        .edad-btn{
            background-color: #f06292;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 25px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .edad-btn:hover{
            transform: scale(1.08);
            background-color: #e14b80;
        }

        /* CARDS */

        .contenedor-cards{
            width: 90%;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
            padding-bottom: 80px;
        }

        .card{
            background-color: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
            transition: 0.3s;
        }

        .card:hover{
            transform: translateY(-8px);
        }

        .card img{
            width: 100%;
            height: 230px;
            object-fit: cover;
        }

        .card-content{
            padding: 20px;
            text-align: center;
        }

        .card-content h3{
            color: #c97f91;
            margin-bottom: 15px;
            font-size: 28px;
        }

        .card-content button{
            background-color: #f8c3d2;
            border: none;
            padding: 12px 25px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }

        .card-content button:hover{
            background-color: #f06292;
            color: white;
        }

        /* FOOTER */

        footer{
            width: 100%;
            background-color: #f06292;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            padding: 30px;
        }

        footer img{
            width: 70px;
        }

        footer h2{
            font-size: 55px;
        }

        /* RESPONSIVE */

        @media(max-width: 900px){

            nav{
                flex-direction: column;
                gap: 20px;
            }

            .nav-links{
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero{
                padding: 30px;
                text-align: center;
                justify-content: center;
            }

            .hero-text h1{
                font-size: 38px;
            }

            .hero-text p{
                font-size: 20px;
            }

            .titulo{
                font-size: 42px;
            }

        }

    </style>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
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
          <a class="nav-link" href="especialista_perfil.php">Especialistas</a>
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


    <!-- HERO -->

    <section class="hero">

        <div class="hero-text">

            <h1>CONECTAR, JUGAR Y APRENDER JUNTOS</h1>

            <p>
                Descubre ideas para disfrutar de tiempo en familia,
                estimular el desarrollo de tus hijos y fortalecer
                el vínculo parental.
            </p>

        </div>

    </section>

    <!-- TITULO -->

    <h1 class="titulo">Actividades</h1>

    <!-- BOTONES -->

    <div class="edades">

        <button class="edad-btn">0-3 años</button>
        <button class="edad-btn">4-6 años</button>
        <button class="edad-btn">7-9 años</button>
        <button class="edad-btn">9-12 años</button>
        <button class="edad-btn">+13 años</button>

    </div>

    <!-- CARDS -->

    <section class="contenedor-cards">

        <div class="card">

            <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Manualidades</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1511895426328-dc8714191300?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Juegos familiares</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Actividades al aire libre</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Lecturas compartidas</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Cocinar juntos</h3>
                <button>Ver más</button>
            </div>

        </div>

        <div class="card">

            <img src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?q=80&w=1200&auto=format&fit=crop">

            <div class="card-content">
                <h3>Trivias</h3>
                <button>Ver más</button>
            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>

        <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png">

        <h2>Parently</h2>

    </footer>

</body>
</html>