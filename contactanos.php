<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parently</title>
    <link rel="stylesheet" href="homepage.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


<style>
 
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}
 
/* FONDO */
body{
    background-color: #f5e8d9;
    padding: 30px;
}
 
/* =========================
   CONTACTO
========================= */
 
.contacto{
    width: 100%;
}
 
/* PARTE SUPERIOR */
.contacto-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}
 
.texto h1{
    color: #c2185b;
    font-size: 38px;
    margin-bottom: 10px;
}
 
.texto p{
    font-size: 18px;
    color: #333;
    line-height: 1.5;
}
 
/* IMAGEN */
.imagen img{
    width: 220px;
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
    background-color: #EFA8CA;
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
    background-color: #EFA8CA;
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
    margin-top: 50px;
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
    background-color: #EFA8CA;
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
 
/* RESPONSIVE */
@media(max-width: 900px){
 
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
 
<!-- =========================
     CONTACTO
========================= -->
 
<section class="contacto">
 
    <div class="contacto-header">
 
        <div class="texto">
            <h1>Contáctanos</h1>
 
            <p>
                Estamos aquí para ayudarte <br>
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
 
            <img src="osito.png" alt="Osito">
 
            <button>Enviar comentario</button>
 
        </div>
 
    </div>
 
    <div class="seguridad">
        🤍 Tu información es segura con nosotros
    </div>
 
</section>
 
</body>
</html>