let foros = [];
let actual = 1;

/* =========================
   CARGAR FOROS (SEGURO)
========================= */

fetch("get_foros.php")
.then(res => res.text())
.then(text => {

  console.log("RAW:", text);

  let data;

  try {
    data = JSON.parse(text);
  } catch (e) {
    console.error("JSON inválido en get_foros.php", text);
    return;
  }

  foros = Array.isArray(data) ? data : [];

  cargarForo(foroInicial);
  cargarDestacado();

})
.catch(err => console.error("Error fetch foros:", err));

/* =========================
   MOSTRAR FORO
========================= */

function cargarForo(id){

  actual = id;

  let foro = foros.find(f => f.id == id);

  if(!foro) return;

  document.getElementById("foro-titulo").innerText = foro.nombre;
  document.getElementById("foro-img").src = "../" + foro.imagen;
  document.getElementById("miembros").innerText = foro.miembros;

  let btn = document.getElementById("btnUnirse");

  if (btn) {
    btn.dataset.estado = "no";
    btn.innerText = "Unirse";
  }

  cargarComentarios();
  cargarDestacado();
}

/* =========================
   COMENTARIOS
========================= */

function cargarComentarios(){

  fetch("get_comentarios.php?foro_id=" + actual)
  .then(r => r.text())
  .then(text => {

    let data;

    try {
      data = JSON.parse(text);
    } catch (e) {
      console.error("Error JSON comentarios", text);
      return;
    }

    let cont = document.getElementById("comentarios");
    if (!cont) return;

    cont.innerHTML = "";

    (Array.isArray(data) ? data : []).forEach(c => {

      cont.innerHTML += `
        <div class="comentario">

          <div class="comentario-top">
            <b>${c.usuario ?? "Anónimo"}</b>
          </div>

          <div class="comentario-texto">
            ${c.texto ?? ""}
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
   UNIRSE (BOTÓN)
========================= */

function unirse(){

  let btn = document.getElementById("btnUnirse");
  if (!btn) return;

  if(btn.dataset.estado !== "unido"){

    btn.dataset.estado = "unido";
    btn.innerText = "Participante";

  } else {

    let modal = document.getElementById("modalSalir");
    if (modal) modal.classList.remove("hidden");
  }
}

/* =========================
   PUBLICAR COMENTARIO
========================= */

function publicar(){

  let input = document.getElementById("inputComentario");
  if (!input) return;

  let texto = input.value;

  if(texto.trim() == "") return;

  fetch("comentarios.php", {
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body:JSON.stringify({
      foro_id:actual,
      comentario:texto,
      usuario:usuario
    })
  })
  .then(r => r.text())
  .then(() => {

    input.value = "";
    cargarComentarios();

  });

}

/* =========================
   ELIMINAR COMENTARIO
========================= */

function eliminarComentario(id){

  fetch("eliminar_comentario.php", {
    method:"POST",
    headers:{ "Content-Type":"application/json" },
    body:JSON.stringify({ id:id })
  })
  .then(() => cargarComentarios());

}

/* =========================
   DESTACADO (SEGURO)
========================= */

function cargarDestacado(){

  fetch("get_destacado.php?foro_id=" + actual)
  .then(r => r.text())
  .then(text => {

    let data;

    try {
      data = JSON.parse(text);
    } catch (e) {
      console.error("Error JSON destacado", text);
      return;
    }

    if(!data || !data.data){

      document.getElementById("destacado-nombre").innerText = "Sin participantes";
      document.getElementById("destacado-info").innerText = "Aún nadie se ha unido";
      document.getElementById("destacado-img").src = "";

      return;
    }

    document.getElementById("destacado-nombre").innerText =
      data.data.nombre_usuario;

    document.getElementById("destacado-info").innerText =
      "Miembro destacado";

  });

}

/* =========================
   BUSCADOR
========================= */

function toggleSearch() {
  const input = document.getElementById("searchInput");

  if (!input) return;

  input.classList.toggle("hidden");

  if (!input.classList.contains("hidden")) {
    input.focus();
  } else {
    input.value = "";
    buscar("");
  }
}

function buscar(texto) {

  let comentarios = document.querySelectorAll(".comentario");
  let encontrados = 0;

  comentarios.forEach(c => {

    let contenido = c.innerText.toLowerCase();

    if (contenido.includes(texto.toLowerCase())) {
      c.style.display = "block";
      encontrados++;
    } else {
      c.style.display = "none";
    }

  });

  let resultado = document.getElementById("resultadoBusqueda");

  if (resultado) {
    resultado.innerText =
      texto === "" ? "" : `Resultados: ${encontrados}`;
  }
}

/* =========================
   MODAL SALIR
========================= */

function confirmarSalida(){

  let btn = document.getElementById("btnUnirse");

  if (btn) {
    btn.dataset.estado = "no";
    btn.innerText = "Unirse";
  }

  cerrarModal();
}

function cerrarModal(){
  let modal = document.getElementById("modalSalir");
  if (modal) modal.classList.add("hidden");
}