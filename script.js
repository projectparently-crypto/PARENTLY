let foros = [];
let actual;

// 🔥 BASE FIJA DE RUTAS (IMPORTANTE)
const BASE = "/parently/PARENTLY/php/";

/* =========================
   CARGAR FOROS
========================= */
fetch(BASE + "get_foros.php")
.then(res => res.text())
.then(text => {

  let data;

  try {
    data = JSON.parse(text);
  } catch (e) {
    console.error("JSON inválido en get_foros.php", text);
    return;
  }

  foros = Array.isArray(data) ? data : [];

  if (typeof foroInicial !== "undefined") {
    cargarForo(foroInicial);
  }

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

  cargarComentarios();
  cargarDestacado();
  actualizarEstado(id);
}


/* =========================
   COMENTARIOS
========================= */
function cargarComentarios(){

  fetch(BASE + "get_comentarios.php?foro_id=" + actual)
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
   UNIRSE / SALIR (TOGGLE)
========================= */
function unirse(){

  fetch(BASE + "unirse_foro.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ foro_id: actual })
  })
  .then(r => r.json())
  .then(() => actualizarEstado(actual))
  .catch(err => console.error(err));
}


/* =========================
   ACTUALIZAR ESTADO (BOTÓN + CONTADOR)
========================= */
function actualizarEstado(id){

  fetch(BASE + "verificar_miembro.php?foro_id=" + id)
  .then(r => r.json())
  .then(data => {

    const btn = document.getElementById("btnUnirse");
    const contador = document.getElementById("miembros");

    if (btn) {
      btn.innerText = data.unido ? "Participante" : "Unirse";
      btn.dataset.estado = data.unido ? "unido" : "no";
    }

    if (contador) {
      contador.innerText = (data.ahora ?? 0) + " miembros";
    }

  })
  .catch(err => console.error("verificar error:", err));
}


/* =========================
   SALIR (MODAL)
========================= */
function confirmarSalida(){

  fetch(BASE + "salir_foro.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ foro_id: actual })
  })
  .then(r => r.json())
  .then(() => {
    cerrarModal();
    actualizarEstado(actual);
  })
  .catch(err => console.error(err));
}

function cerrarModal(){
  const modal = document.getElementById("modalSalir");
  if (modal) modal.classList.add("hidden");
}


/* =========================
   ELIMINAR COMENTARIO
========================= */
function eliminarComentario(id){

  fetch(BASE + "eliminar_comentario.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id:id })
  })
  .then(() => cargarComentarios());
}


/* =========================
   DESTACADO
========================= */
function cargarDestacado(){

  fetch(BASE + "get_destacado.php?foro_id=" + actual)
  .then(r => r.text())
  .then(text => {

    let data;

    try {
      data = JSON.parse(text);
    } catch (e) {
      console.error("Error JSON destacado", text);
      return;
    }

    const nombre = document.getElementById("destacado-nombre");
    const info = document.getElementById("destacado-info");

    if(!data || !data.data){

      if (nombre) nombre.innerText = "Sin participantes";
      if (info) info.innerText = "Aún nadie se ha unido";
      return;
    }

    if (nombre) nombre.innerText = data.data.nombre_usuario;
    if (info) info.innerText = "Miembro destacado";

  });
}


/* =========================
   BUSCADOR
========================= */
function toggleSearch(){

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

function buscar(texto){

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
    resultado.innerText = texto === "" ? "" : `Resultados: ${encontrados}`;
  }
}