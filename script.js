let foros = [];
let actual = 1;


/* =========================
   CARGAR FOROS
========================= */

fetch("get_foros.php")

.then(res => res.json())

.then(data => {

  foros = data;

  cargarForo(foroInicial);

  cargarDestacado();

});


/* =========================
   MOSTRAR FORO
========================= */

function cargarForo(id){

  actual = id;

  let foro = foros.find(f => f.id == id);

  if(!foro) return;

  document.getElementById("foro-titulo").innerText =
  foro.nombre;

  document.getElementById("foro-img").src =
  foro.imagen;

  document.getElementById("miembros").innerText =
  foro.miembros;

}

function cargarForo(id){

  actual = id;

  let foro = foros.find(f => f.id == id);

  if(!foro) return;

  document.getElementById("foro-titulo").innerText =
  foro.nombre;

  document.getElementById("foro-img").src =
  foro.imagen;

  document.getElementById("miembros").innerText =
  foro.miembros;

  cargarComentarios(); // <- AGREGA ESTO

}

function cargarComentarios(){

  fetch("get_comentarios.php?foro_id=" + actual)

  .then(r => r.json())

  .then(data => {

    let cont = document.getElementById("comentarios");

    cont.innerHTML = "";

    data.forEach(c => {

      cont.innerHTML += `
      
      <div class="comentario">

        <div class="comentario-top">

          <b>${c.usuario}</b>

        </div>

        <div class="comentario-texto">

          ${c.texto}

        </div>

        <button onclick="eliminarComentario(${c.id})">

          Eliminar

        </button>

      </div>

      `;

    });

  });

}

/* =========================
   UNIRSE
========================= */

function unirse(){

  let btn =
  document.getElementById("btnUnirse");

  if(btn.innerText == "Unirse"){

    btn.innerText = "Salir";

  }else{

    btn.innerText = "Unirse";

  }

}

function publicar(){

  let texto = document.getElementById("inputComentario").value;

  if(texto.trim() == "") return;

  fetch("comentarios.php", {

    method:"POST",

    headers:{
      "Content-Type":"application/json"
    },

    body:JSON.stringify({
      foro_id:actual,
      comentario:texto,
      usuario:usuario
    })

  })
  .then(r=>r.json())
  .then(data=>{

    document.getElementById("inputComentario").value="";

    cargarComentarios();

  });

}

function eliminarComentario(id){

  fetch("eliminar_comentario.php", {

    method:"POST",

    headers:{
      "Content-Type":"application/json"
    },

    body:JSON.stringify({
      id:id
    })

  })

  .then(r => r.json())

  .then(data => {

    cargarComentarios();

  });

}

function cargarDestacado(){

  fetch("get_destacado.php?foro_id=" + actual)
  .then(r => r.json())
  .then(data => {

    if(!data) return;

    document.querySelector(".destacado-user h3").innerText =
      data.usuario;

    document.querySelector(".destacado-user p").innerText =
      "Se unió hace " + calcularTiempo(data.fecha_union);

  });

}
function calcularTiempo(fecha){

  let f = new Date(fecha);
  let ahora = new Date();

  let dias = Math.floor((ahora - f) / (1000 * 60 * 60 * 24));

  if(dias == 0) return "hoy";
  if(dias == 1) return "1 día";
  return dias + " días";
}

function cargarDestacado(){

  fetch("get_destacado.php?foro_id=" + actual)

  .then(r => r.json())

  .then(data => {

    console.log(data);

    //  si no hay usuario destacado
    if(!data || !data.usuario){

      document.getElementById("destacado-nombre").innerText =
        "Sin participantes";

      document.getElementById("destacado-info").innerText =
        "Aún nadie se ha unido";

      document.getElementById("destacado-img").src = "";

      return;
    }

    // SI EXISTE
    document.getElementById("destacado-nombre").innerText =
      data.usuario;

    document.getElementById("destacado-info").innerText =
      "Miembro destacado";

  });

}