let foros = [];
let actual;
let anonimo = false;
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
function tiempoRelativo(fecha){

    const ahora = new Date();
    const f = new Date(fecha);

    const segundos = Math.floor((ahora - f) / 1000);

    if(segundos < 30) return "Hace un momento";

    if(segundos < 60) return "Hace unos segundos";

    const minutos = Math.floor(segundos / 60);

    if(minutos === 1) return "Hace 1 min";
    if(minutos < 60) return `Hace ${minutos} min`;

    const horas = Math.floor(minutos / 60);

    if(horas === 1) return "Hace 1 h";
    if(horas < 24) return `Hace ${horas} h`;

    const dias = Math.floor(horas / 24);

    if(dias === 1) return "Ayer";
    if(dias < 7) return `Hace ${dias} días`;

    return f.toLocaleDateString("es-ES",{
        day:"numeric",
        month:"short",
        year:"numeric"
    });
}

function renderComentario(c) {

  const foto = c.foto_perfil?.trim()
    ? "../photos/" + c.foto_perfil
    : "../photos/default.png";

 let respuestasHTML = "";

    if (c.children && c.children.length > 0) {
        c.children.forEach(r => {
            respuestasHTML += renderRespuesta(r);
        });
    }
  return `
    <div class="comentario-card"
         data-id="${c.id}"
         data-respuesta-id="${c.id}">

      <div class="comentario-header">

        <div class="left">

          ${
            c.anonimo == 1
              ? `
                <div class="avatar anonimo">
                    <i class="fa-solid fa-user"></i>
                </div>
              `
              : `
                <img
                  class="avatar"
                  src="${foto}"
                  onerror="this.src='../photos/default.png'"
                >
              `
          }

          <div class="comentario-user">
            <b>${c.nombre_usuario}</b>
            <span class="comentario-fecha">
                ${tiempoRelativo(c.fecha)}
                <i class="fa-solid fa-earth-americas"></i>
            </span>
          </div>

        </div>

        <div class="menu-wrapper">

          <button
            class="menu-btn"
            onclick="toggleMenu(this,event)">

            <i class="fa-solid fa-ellipsis-vertical"></i>

          </button>

          <div class="menu-dropdown hidden">

            <button onclick="editarComentario(${c.id})">
              <i class="fa-solid fa-pen"></i>
              Editar
            </button>

            <button onclick="eliminarComentario(${c.id})">
              <i class="fa-solid fa-trash"></i>
              Eliminar
            </button>

            <button onclick="reportar(${c.id}, 'comentario')">
              <i class="fa-solid fa-flag"></i>
              Reportar
            </button>

          </div>

        </div>

      </div>

      <div class="comentario-body">
        ${c.texto}
      </div>

      <div class="comentario-actions">

        <button
          class="like-btn"
          onclick="like(${c.id},this)">

          <i class="fa-regular fa-heart"></i>
          <span>${c.likes ?? 0}</span>

        </button>

        <button class="reply-btn" onclick="responder(${c.id})">
            <i class="fa-regular fa-comment"></i>
            Responder
        </button>

      </div>

      <div class="contenedor-respuestas">
        ${respuestasHTML}
      </div>

    </div>
  `;
}

function renderRespuesta(r){

    const foto = r.foto_perfil?.trim()
        ? "../photos/" + r.foto_perfil
        : "../photos/default.png";

    

    return `

    <div class="respuesta"
         data-id="${r.id}"
         data-respuesta-id="${r.id}">

        ${
            r.anonimo == 1
            ? `
                <div class="avatar anonimo">
                    <i class="fa-solid fa-user"></i>
                </div>
            `
            : `
                <img
                    class="avatar"
                    src="${foto}"
                    onerror="this.src='../photos/default.png'">
            `
        }

        <div class="respuesta-info">

            <div class="respuesta-header">

                <div>

                    <b>${r.nombre_usuario}</b><br>

                    <span class="comentario-fecha">
                        ${tiempoRelativo(r.fecha)}
                        <i class="fa-solid fa-earth-americas"></i>
                    </span>

                </div>

                <div class="menu-wrapper">

                    <button
                        class="menu-btn"
                        onclick="toggleMenu(this,event)">

                        <i class="fa-solid fa-ellipsis-vertical"></i>

                    </button>

                    <div class="menu-dropdown hidden">

                        <button onclick="editarRespuesta(${r.id})">
                            <i class="fa-solid fa-pen"></i>
                            Editar
                        </button>

                        <button onclick="eliminarComentario(${r.id})">
                            <i class="fa-solid fa-trash"></i>
                            Eliminar
                        </button>

                        <button onclick="reportar(${r.id},'respuesta')">
                            <i class="fa-solid fa-flag"></i>
                            Reportar
                        </button>

                    </div>

                </div>

            </div>

            <div class="respuesta-texto">
                ${r.texto}
            </div>

            <div class="comentario-actions">

                <button
                    class="like-btn"
                    onclick="like(${r.id},this)">

                    <i class="fa-regular fa-heart"></i>
                    <span>${r.likes ?? 0}</span>

                </button>

                <button
                    class="reply-btn"
                    onclick="responder(${r.id})">

                    <i class="fa-regular fa-comment"></i>
                    Responder

                </button>

            </div>

               </div>

    </div>
`;
}

function cargarComentarios() {

    fetch(BASE + "get_comentarios.php?foro_id=" + actual)
    .then(r => r.json())
    .then(data => {

        const cont = document.getElementById("comentarios");
        cont.innerHTML = "";

        const mapa = {};

        data.forEach(c => {
            c.parent_id = Number(c.parent_id) || 0;
            c.children = [];
            mapa[c.id] = c;
        });

        // Crear árbol
        data.forEach(c => {

            if(c.parent_id != 0 && mapa[c.parent_id]){
                mapa[c.parent_id].children.push(c);
            }

        });

        // Aplanar respuestas
        function aplanar(lista){

            let resultado = [];

            lista.forEach(item =>{

                resultado.push(item);

                if(item.children.length){
                    resultado.push(...aplanar(item.children));
                }

            });

            return resultado;

        }

        // Mostrar comentarios
        data
            .filter(c => c.parent_id == 0)
            .forEach(c =>{

                c.children = aplanar(c.children);

                cont.innerHTML += renderComentario(c);

            });

    });

}

function enviarRespuesta(id){

  const box = document.getElementById("respuesta-" + id);
  const texto = box.querySelector("textarea").value.trim();

  if(!texto) return;

  fetch(BASE + "comentarios.php", {
    method: "POST",
    headers: {"Content-Type":"application/json"},
    body: JSON.stringify({
      foro_id: actual,
      comentario: texto,
      parent_id: id
    })
  })
  .then(r => r.json())
  .then(() => {
    cargarComentarios();
  });

}
function like(id, btn){

  fetch(BASE + "like.php", {
    method:"POST",
    headers:{"Content-Type":"application/json"},
    body: JSON.stringify({
      comentario_id: id
    })
  })
  .then(r => r.json())
  .then(data => {

    const span = btn.querySelector("span");
    const icon = btn.querySelector("i");

    span.innerText = data.likes ?? 0;

    if (data.liked) {
      icon.classList.remove("fa-regular");
      icon.classList.add("fa-solid");
    } else {
      icon.classList.add("fa-regular");
      icon.classList.remove("fa-solid");
    }

  })
  .catch(err => console.error("LIKE ERROR:", err));

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
      btn.innerHTML = data.unido
        ? `<i class="fa-solid fa-check"></i> Participante`
        : `<i class="fa-solid fa-plus"></i> Unirse`;

      btn.dataset.estado = data.unido ? "unido" : "no";
    }

    if (contador) {
      contador.innerText = (data.ahora ?? 0) + " miembros";
    }

  })
  .catch(err => console.error("verificar error:", err));
}

function abrirModalSalida(){

  const btn = document.getElementById("btnUnirse");

  if (btn.dataset.estado !== "unido") {
    unirse();
    return;
  }

  document.getElementById("modalSalir")?.classList.remove("hidden");
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
  let comentarios = document.querySelectorAll(".comentario-card");
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
document.addEventListener("click", function () {
  document.querySelectorAll(".menu-dropdown")
    .forEach(m => m.classList.add("hidden"));
});
function toggleMenu(btn, event){
  if (event) event.stopPropagation();

  const menu = btn.closest(".menu-wrapper").querySelector(".menu-dropdown");

  document.querySelectorAll(".menu-dropdown").forEach(m => {
    if (m !== menu) m.classList.add("hidden");
  });

  menu.classList.toggle("hidden");
}
function publicar(){

  const input = document.querySelector("#inputComentario");

  if(!input){
    console.error("No existe inputComentario");
    return;
  }

  const texto = input.value.trim();
  if(texto === "") return;

  fetch(BASE+"comentarios.php",{
    method:"POST",
    headers:{"Content-Type":"application/json"},
    body:JSON.stringify({
      foro_id: actual,
      comentario: texto,
      parent_id: 0,
      anonimo: anonimo ? 1 : 0
    })
  })
  .then(r=>r.json())
  .then(data => {

    console.log("PUBLICADO:", data);

    input.value = "";
    cargarComentarios(); // 🔥 refresca todo

  });

}

function responder(id){

    const cont = document.querySelector(`[data-id="${id}"]`);
    if(!cont) return;

    let box = document.getElementById("respuesta-" + id);

    if(box){
        box.remove();
        return;
    }

    box = document.createElement("div");
    box.id = "respuesta-" + id;
    box.className = "respuesta-box";

    box.innerHTML = `
        <textarea placeholder="Escribe una respuesta..."></textarea>

        <div class="respuesta-box-actions">
            <button onclick="enviarRespuesta(${id})">
                <i class="fa-solid fa-paper-plane"></i>
                Publicar
            </button>

            <button onclick="this.closest('.respuesta-box').remove()">
                <i class="fa-solid fa-xmark"></i>
                Cancelar
            </button>
        </div>
    `;

    // 🔥 FIX: buscar contenedor seguro
    const target =
        cont.querySelector(".contenedor-respuestas") ||
        cont;

    target.appendChild(box);
}

function editarComentario(id){

  // evitar duplicados
  const existente = document.getElementById("edit-" + id);
  if (existente) {
    existente.remove();
    return;
  }

  const comentario = document.querySelector(`[data-id="${id}"]`);
  if(!comentario) return;

  const textoActual = comentario.querySelector(".comentario-body").innerText;

  const div = document.createElement("div");
  div.className = "edit-box";
  div.id = "edit-" + id;

  div.innerHTML = `
    <textarea class="edit-input">${textoActual}</textarea>

    <div class="edit-actions">
      <button class="btn-save" onclick="guardarEdicion(${id})">Guardar</button>
      <button class="btn-cancel" onclick="this.parentElement.parentElement.remove()">Cancelar</button>
    </div>
  `;

  comentario.appendChild(div);
}

function guardarEdicion(id){

  const box = document.getElementById("edit-" + id);
  if(!box) return;

  const nuevoTexto = box.querySelector("textarea").value;

  if(nuevoTexto.trim() === "") return;

  fetch(BASE + "editar_comentario.php", {
    method: "POST",
    headers: {"Content-Type":"application/json"},
    body: JSON.stringify({
      id: id,
      texto: nuevoTexto
    })
  })
  .then(r => r.json())
  .then(() => {

    const comentario = document.querySelector(`[data-id="${id}"]`);
    if(!comentario) return;

    // actualizar SOLO el texto en pantalla
    const body = comentario.querySelector(".comentario-body");
    body.innerText = nuevoTexto;

    // cerrar editor
    box.remove();

  })
  .catch(err => console.error(err));

}


function editarRespuesta(id){

  const cont = document.querySelector(`[data-respuesta-id="${id}"]`);
  if(!cont) return;

  const textoActual = cont.querySelector(".respuesta-texto").innerText;

  // evitar duplicados
  if(cont.querySelector(".edit-reply-box")) return;

  const div = document.createElement("div");
  div.className = "edit-reply-box";

  div.innerHTML = `
    <textarea class="edit-input">${textoActual}</textarea>

    <div class="edit-actions">
      <button class="btn-save" onclick="guardarEdicionRespuesta(${id})">Guardar</button>
      <button class="btn-cancel" onclick="this.closest('.edit-reply-box').remove()">Cancelar</button>
    </div>
  `;

  cont.appendChild(div);
}

function guardarEdicionRespuesta(id){

  const box = document.querySelector(`#respuesta-${id} .edit-reply-box`);
  if(!box) return;

  const nuevoTexto = box.querySelector("textarea").value;

  fetch(BASE + "editar_comentario.php", {
    method: "POST",
    headers: {"Content-Type":"application/json"},
    body: JSON.stringify({
      id: id,
      texto: nuevoTexto
    })
  })
  .then(r => r.json())
  .then(() => {

    const cont = document.querySelector(`[data-respuesta-id="${id}"]`);
    if(!cont) return;

    cont.querySelector(".respuesta-texto").innerText = nuevoTexto;

    box.remove();

  });

}
  function agregarComentarioEnPantalla(c){

    if (!c) {
        console.error("Comentario vacío");
        return;
    }

    console.log("Comentario recibido:", c);

  const cont = document.getElementById("comentarios");

  const html = `
    <div class="comentario-card" data-id="${c.id}">

      <div class="comentario-header">

        <div class="left">

          ${
            c.anonimo == 1
            ? `<div class="avatar anonimo">
                <i class="fa-solid fa-user-secret"></i>
              </div>`
            : `<img class="avatar"
                src="../photos/${c.foto_perfil || 'default.png'}"
                onerror="this.src='../photos/default.png'">`
          }

          <div class="comentario-user">
            <b>${c.nombre_usuario}</b>
            <span>${c.fecha}</span>
          </div>

        </div>

      </div>

      <div class="comentario-body">
        ${c.texto}
      </div>

      <div class="comentario-actions">

        <button class="like-btn" onclick="like(${c.id}, this)">
          <i class="fa-regular fa-heart"></i>
          <span>0</span>
        </button>

        <button onclick="responder(${c.id})">
          <i class="fa-regular fa-comment"></i>
          Responder
        </button>

      </div>

      <div class="contenedor-respuestas"></div>

    </div>
  `;

  cont.insertAdjacentHTML("afterbegin", html);
}


function avatarURL(foto){
  return foto && foto.trim() !== ""
    ? `../photos/${foto}`
    : `../photos/default.png`;
}

function toggleAnonimo(){

    anonimo = !anonimo;

    const btn = document.getElementById("btnAnonimo");

    if(anonimo){
        btn.innerHTML = '<i class="fa-solid fa-user-secret"></i> Anónimo: ON';
    } else {
        btn.innerHTML = '<i class="fa-regular fa-user"></i> Anónimo: OFF';
    }

}
setInterval(() => {

    if(actual){
        cargarComentarios();
    }

},60000);

function reportar(id){

    const modal = document.createElement("div");
    modal.className = "report-modal";

    modal.innerHTML = `
        <div class="report-box">
            <h3>Reportar contenido</h3>

            <textarea id="motivo-report" placeholder="Escribe el motivo..."></textarea>

            <div class="report-actions">
                <button onclick="enviarReporte(${id})">Enviar</button>
                <button onclick="this.closest('.report-modal').remove()">Cancelar</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
}

function enviarReporte(id){

    const texto = document.getElementById("motivo-report").value;

    if(!texto.trim()) return;

    fetch(BASE + "reportar.php",{
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({
            id:id,
            foro_id:actual,
            motivo:texto
        })
    })
    .then(r=>r.json())
    .then(data=>{

        mostrarToast(
            data.success
                ? "Reporte enviado correctamente"
                : data.mensaje
        );

        document.querySelector(".report-modal")?.remove();
    });
}
function mostrarToast(mensaje){

    const t = document.createElement("div");
    t.className = "toast";
    t.innerText = mensaje;

    document.body.appendChild(t);

    setTimeout(()=> t.classList.add("show"), 10);

    setTimeout(()=> t.remove(), 2500);
}