window.actual = window.foroInicial || 0;
let foros = [];
window.imagenesComentario = [];
let imagenesRespuesta = new Map();
let anonimo = false;

// 🔥 BASE FIJA DE RUTAS (IMPORTANTE)
const BASE = "/parently/PARENTLY/php/";
const foroActual = new URLSearchParams(window.location.search).get("id");
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

            ${c.es_mio ? `
            <button onclick="editarComentario(${c.id})">
                <i class="fa-solid fa-pen"></i>
                Editar
            </button>

            <button onclick="eliminarComentario(${c.id})">
                <i class="fa-solid fa-trash"></i>
                Eliminar
            </button>
            ` : ""}

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
        
      ${
      c.imagenes && c.imagenes !== ""
      ?
      `
      <div class="comentario-imagenes">
      ${(() => {
      let imgs = [];
      try { imgs = JSON.parse(c.imagenes); } catch(e) {}

      return imgs.map(img => `
        <img src="../uploads/comentarios/${img}"
            onclick="verImagen(this.src)">
      `).join("");
      })()}
      </div>
      `
      :
      ""
      }
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

                        ${r.es_mio ? `
                  <button onclick="editarRespuesta(${r.id})">
                      <i class="fa-solid fa-pen"></i>
                      Editar
                  </button>

                  <button onclick="eliminarComentario(${r.id})">
                      <i class="fa-solid fa-trash"></i>
                      Eliminar
                  </button>
                  ` : ""}

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
              ${
                  r.imagenes
                  ? `
                  <div class="comentario-imagenes">

                      ${
                          JSON.parse(r.imagenes).map(img=>`
                              <img
                                  src="../uploads/comentarios/${img}"
                                  onclick="verImagen(this.src)">
                          `).join("")
                      }

                  </div>
                  `
                  : ""
              }
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

    let box = document.getElementById("respuesta-" + id);
    if(!box) return;

    let texto = box.querySelector("textarea").value.trim();

    if(texto === ""){
        alert("Escribe una respuesta");
        return;
    }

    let form = new FormData();

    form.append("foro_id", new URLSearchParams(window.location.search).get("id"));
    form.append("comentario", texto);
    form.append("parent_id", id);

    // ✅ SOLO ESTA LÍNEA
    form.append("anonimo", box.dataset.anonimo || "0");

    const boxId = box.id;
    const files = imagenesRespuesta.get(boxId) || [];

      for(const file of files){
          form.append("imagenes[]", file);
      }

    fetch("/parently/PARENTLY/php/comentarios.php", {
        method: "POST",
        body: form
    })
    .then(r => r.json())
    .then(data => {

        if(!data.ok){
            alert(data.mensaje);
            return;
        }

        imagenesRespuesta.delete(boxId);
        box.remove();

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

    // ⭐ ACTUALIZAR EL OBJETO DEL FORO
    const foro = foros.find(f => Number(f.id) === Number(id));

    if (foro) {
  foro.miembros = Number(data.ahora);

  // Si la pestaña Sobre está abierta, actualízala
  if (document.getElementById("sobre")) {
    cargarSobre();
  }
}
  })
  .catch(err => console.error("verificar error:", err));
}

function abrirModalSalida() {

  const btn = document.getElementById("btnUnirse");

  if (!btn) return;

  const estado = btn.dataset.estado || "no";

  if (estado !== "unido") {
    unirse();
    return;
  }

  const modal = document.getElementById("modalSalir");
  if (!modal) return console.error("No existe modalSalir");

  modal.classList.remove("hidden");
}

function cerrarModalSalida() {
  const modal = document.getElementById("modalSalir");
  if (!modal) return;
  modal.classList.add("hidden");
}

function confirmarSalida() {
  fetch(BASE + "salir_foro.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ foro_id: actual })
  })
  .then(r => r.json())
  .then(() => {
    cerrarModalSalida();
    actualizarEstado(actual);
  })
  .catch(console.error);
}

/* =========================
   ELIMINAR COMENTARIO
========================= */
function eliminarComentario(id){

    fetch(BASE + "eliminar_comentario.php",{
        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },
        body:JSON.stringify({ id:id })
    })
    .then(r=>r.json())
    .then(data=>{

        if(data.ok){
            cargarComentarios();
        }else{
            alert(data.mensaje);
        }

    });

}

/* =========================
   DESTACADO
========================= */
function cargarDestacado(){

    fetch(BASE + "get_destacado.php?foro_id=" + actual)
    .then(r => r.json())
    .then(u => {

        if(!u) return;

        document.getElementById("destacado-img").src =
            u.foto_perfil ? "../photos/" + u.foto_perfil : "../photos/default.png";

        document.getElementById("destacado-nombre").innerText =
            u.nombre_usuario;

        document.getElementById("destacado-comentarios").innerHTML =
            `<i class="fa-solid fa-comments"></i> ${u.total_comentarios} comentarios`;

        document.getElementById("destacado-extra").innerHTML =
            `<i class="fa-solid fa-fire"></i> Miembro más activo`;
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

function publicar() {

  const input = document.querySelector("#inputComentario");
  const fileInput = document.querySelector("#inputImagen");

  if (!input) return;

  const texto = input.value.trim();
  if (texto === "") return;

  const form = new FormData();

  form.append("foro_id", actual);
  form.append("comentario", texto);
  form.append("parent_id", 0);
  form.append("anonimo", anonimo ? 1 : 0);

  console.log("ANTES DE ENVIAR:", imagenesComentario);

  for (const file of window.imagenesComentario) {
    form.append("imagenes[]", file);
  }

  fetch(BASE + "comentarios.php", {
    method: "POST",
    body: form
  })
  .then(r => r.json())
  .then(data => {

    if (!data.ok) return;

    input.value = "";
    if (fileInput) fileInput.value = "";

    imagenesComentario = []; // 🔥 IMPORTANTÍSIMO

    const preview = document.querySelector(".preview-comentario");
   
   if (preview) preview.innerHTML = "";

    cargarComentarios();
  })
  .catch(console.error);
}

function responder(id){
  
    const cont = document.querySelector(`[data-id="${id}"]`);
    if(!cont) return;

    let box = document.getElementById("respuesta-" + id);

    if(box){
        box.remove();
        return;
    }
    imagenesRespuesta.set("respuesta-" + id, []);
    box = document.createElement("div");
    box.id = "respuesta-" + id;
    box.className = "respuesta-box";
    box.dataset.anonimo = "0";
    box.innerHTML = `
  
    <textarea
        class="respuesta-texto"
        placeholder="Escribe una respuesta..."></textarea>

    <label class="media-btn">
    <i class="fa-solid fa-image"></i>
    <span class="media-text">Adjuntar imagen</span>
    <div class="preview-respuesta"></div>
    <input
        type="file"
        class="respuestaImagen"
        multiple
        accept="image/*"
        hidden>
    </label>

    <div class="respuesta-box-actions">
        <button onclick="enviarRespuesta(${id})">
            <i class="fa-solid fa-paper-plane"></i>
            Publicar
        </button>
        <button type="button" class="btn-anonimo" onclick="toggleAnonimoRespuesta(this)">
            Anónimo: OFF
        </button>
        <button onclick="this.closest('.respuesta-box').remove()">
            <i class="fa-solid fa-xmark"></i>
            Cancelar
        </button>
    </div>
`;
const input = box.querySelector(".respuestaImagen");

input.addEventListener("change", function(e){

    const preview = box.querySelector(".preview-respuesta");

    preview.innerHTML = "";

    const files = [];

    for (const file of e.target.files) {

        files.push(file);

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
    }

    imagenesRespuesta.set(box.id, files);
});
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

  const cont = document.querySelector(`[data-respuesta-id="${id}"]`);

  if(!cont){
    console.log("No existe respuesta:", id);
    return;
  }

  const editor = cont.querySelector(".edit-reply-box");
  if(!editor) return;

  const texto = editor.querySelector("textarea").value.trim();
  if(texto === "") return;

  fetch(BASE + "editar_comentario.php", {
    method: "POST",
    headers: {"Content-Type":"application/json"},
    body: JSON.stringify({
      id: id,
      texto: texto
    })
  })
  .then(r => r.json())
  .then(() => {

    const body = cont.querySelector(".respuesta-texto");
    if(body){
      body.innerText = texto;
    }

    editor.remove();
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

function verMiembros(){

    fetch(BASE + "get_lista_miembros.php?foro_id=" + actual)
    .then(r => r.json())
    .then(data => {

        let html = "";

        data.forEach(m => {

            const foto = m.foto_perfil
                ? "../photos/" + m.foto_perfil
                : "../photos/default.png";

            html += `
            <div class="miembro-item">

                <img src="${foto}"
                    onerror="this.src='../photos/default.png'">

                <div class="miembro-info">
                    <b style="cursor:pointer" onclick="abrirPerfil(${m.usuario_id})">
                        ${m.nombre_usuario}
                    </b>
                    <span>Se unió ${tiempoRelativo(m.fecha_union)}</span>
                </div>

                <div class="menu-wrapper">

                    <button class="menu-btn"
                            onclick="toggleMenu(this,event)">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>

                    <div class="menu-dropdown hidden">

                        <button onclick="abrirPerfil(${m.usuario_id})">
                            <i class="fa-solid fa-user"></i>
                            Ver perfil
                        </button>

                       ${m.usuario_id == window.usuarioActual ? "" : `
                        <button onclick="reportarUsuario(${m.usuario_id})">
                            <i class="fa-solid fa-flag"></i>
                            Reportar usuario
                        </button>
                        `}

                    </div>

                </div>

            </div>
            `;
        });

        document.getElementById("listaMiembros").innerHTML = html;
        document.getElementById("modalMiembros").classList.remove("hidden");

    });

}

function cerrarMiembros(){

    document.getElementById("modalMiembros")
        .classList.add("hidden");

}

let usuarioReportado = null;

function reportarUsuario(id){
    usuarioReportado = id;

    document.getElementById("modalReporte")
        .classList.remove("hidden");
}

function cerrarReporte(){
    document.getElementById("modalReporte")
        .classList.add("hidden");

    document.getElementById("motivoReporte").value = "";
    usuarioReportado = null;
}

function enviarReporteUsuario(){

    const motivo = document.getElementById("motivoReporte").value.trim();

    if(!motivo) return;

    fetch(BASE + "reportar_usuario.php", {
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify({
            usuario_id: usuarioReportado,
            foro_id: actual,
            motivo: motivo
        })
    })
    .then(r=>r.json())
    .then(data=>{

        cerrarReporte();

        mostrarToast(
            data.success
                ? "Usuario reportado"
                : "Error al reportar"
        );

    });
}

let perfilActual = null;

function abrirPerfil(id){

    perfilActual = id;

    fetch(BASE + "get_perfil.php?id=" + id + "&foro_id=" + actual)
    .then(r => r.json())
    .then(data => {

        if(!data) return;

        document.getElementById("perfilNombre").innerText = data.nombre_usuario || "Desconocido";
        document.getElementById("perfilBio").innerText = data.bio || "Sin bio";
        document.getElementById("perfilForos").innerText = data.foros ?? 0;
        document.getElementById("perfilComentarios").innerText = data.comentarios ?? 0;

        const fecha = data.fecha_registro
            ? new Date(data.fecha_registro).toLocaleDateString()
            : "Desconocido";

        document.getElementById("perfilMiembroDesde").innerText = fecha;

        document.getElementById("perfilFoto").src = data.foto_perfil
            ? "../photos/" + data.foto_perfil
            : "../photos/default.png";

        // 🔥 AQUÍ ESTÁ LA CLAVE
        const acciones = document.getElementById("perfilAcciones");
        acciones.innerHTML = "";

        if (id != window.usuarioActual) {
            acciones.innerHTML = `
            `;
        }

        document.getElementById("modalPerfil").classList.remove("hidden");
    });
}
function cerrarPerfil(){
    document.getElementById("modalPerfil").classList.add("hidden");
}

function verImagen(src){
    document.getElementById("modalImg").src = src;
    document.getElementById("modal").style.display = "flex";
}

function cerrarModal(){
  document.getElementById("modal").style.display = "none";
  document.getElementById("modalImg").src = "";
}



function toggleAnonimoRespuesta(btn){

    const box = btn.closest(".respuesta-box");

    if(box.dataset.anonimo === "1"){
        box.dataset.anonimo = "0";
        btn.innerHTML = '<i class="fa-regular fa-user"></i> Anónimo: OFF';
        btn.classList.remove("on");
    } else {
        box.dataset.anonimo = "1";
        btn.innerHTML = '<i class="fa-solid fa-user-secret"></i> Anónimo: ON';
        btn.classList.add("on");
    }
}

document.addEventListener("change", function (e) {

  if (e.target.id !== "inputImagen") return;

  const preview = document.querySelector(".preview-comentario");

  window.imagenesComentario = [];

  if (preview) preview.innerHTML = "";

  for (const file of e.target.files) {
    window.imagenesComentario.push(file);

    const img = document.createElement("img");
    img.src = URL.createObjectURL(file);
    preview.appendChild(img);
  }

  console.log("IMAGENES OK:", window.imagenesComentario);
});

document.addEventListener("change", function (e) {

  if (!e.target.classList.contains("respuestaImagen")) return;

  const box = e.target.closest(".respuesta-box");
  if (!box) return;

  const preview = box.querySelector(".preview-respuesta");
  if (!preview) return;

  preview.innerHTML = "";

  const files = [];

  for (const file of e.target.files) {

    files.push(file);

    const img = document.createElement("img");
    img.src = URL.createObjectURL(file);
    preview.appendChild(img);
  }

  // guardar archivos en memoria
  imagenesRespuesta.set(box.id, files);

});
function cargarMedia(){

    fetch(BASE + "get_media.php?foro_id=" + actual)
    .then(r => r.json())
    .then(data => {

        const grid = document.getElementById("mediaGrid");
        grid.innerHTML = "";

        data.forEach(item => {

            console.log("MEDIA ITEM:", item);

            let imagenes = [];

            try {
                imagenes = JSON.parse(item.imagenes);
            } catch(e){}

            const esAnonimo = Number(item.anonimo) === 1;

            // 👇 NOMBRE (con icono si es anónimo)
            const nombre = esAnonimo
                ? `<span class="anonimo-text">
                        <i class="fa-solid fa-user-secret"></i> Anónimo
                   </span>`
                : item.nombre_usuario;

            // 👇 FOTO (blindada contra fugas)
            let foto;

            if (esAnonimo) {
                foto = "../photos/default.png";
            } else {
                foto = item.foto_perfil;

                if (!foto || foto.trim() === "") {
                    foto = "default.png";
                }

                foto = "../photos/" + foto;
            }

            imagenes.forEach(img => {

                grid.innerHTML += `
                <div class="media-card">

                    <div class="media-image">

                        <img
                            src="../uploads/comentarios/${img}"
                            onclick="verImagen(this.src)">

                        <div class="menu-wrapper">

                            <button class="media-menu-btn"
                                onclick="toggleMenu(this,event)">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="menu-dropdown hidden">

                                ${
                                    item.es_mio
                                    ? `
                                        <button onclick="eliminarComentario(${item.id})">
                                            <i class="fa-solid fa-trash"></i>
                                            Eliminar
                                        </button>
                                    `
                                    : `
                                        <button onclick="reportar(${item.id})">
                                            <i class="fa-solid fa-flag"></i>
                                            Reportar
                                        </button>
                                    `
                                }

                            </div>

                        </div>

                    </div>

                    <div class="media-user">

                        <img
                            class="media-avatar"
                            src="${foto}"
                            onerror="this.src='../photos/default.png'">

                        <div class="media-info">
                            <b>${nombre}</b>
                            <small>${tiempoRelativo(item.fecha)}</small>
                        </div>

                    </div>

                </div>`;
            });

        });

    });
}

function cambiarTab(btn, id){

    document.querySelectorAll(".seccion").forEach(sec=>{
        sec.style.display="none";
    });

    document.getElementById(id).style.display="block";

    document.querySelectorAll(".tab").forEach(tab=>{
        tab.classList.remove("active");
    });

    btn.classList.add("active");


    if(id==="media"){
        cargarMedia();
    }


    if(id==="sobre"){
        cargarSobre();
    }

}

function cargarSobre(){

    fetch(BASE + "verificar_miembro.php?foro_id=" + actual)
    .then(r => r.json())
    .then(data => {

        const foro = foros.find(f => Number(f.id) === Number(actual));

        if(!foro) return;

        // Actualizar el objeto del foro con el valor real
        foro.miembros = Number(data.ahora);

        document.getElementById("sobre").innerHTML = `

        <div class="sobre-container">

            <div class="sobre-header">

                <h2>
                    <i class="fa-solid fa-circle-info"></i>
                    ${foro.nombre}
                </h2>

                <p>
                    ${foro.descripcion || "Información de esta comunidad"}
                </p>

            </div>

            <div class="sobre-stats">

                <div class="sobre-stat">
                    <i class="fa-solid fa-users"></i>
                    <b>${foro.miembros}</b>
                    <span>Miembros</span>
                </div>

                <div class="sobre-stat">
                    <i class="fa-solid fa-comments"></i>
                    <b>${foro.comentarios || 0}</b>
                    <span>Comentarios</span>
                </div>

                <div class="sobre-stat">
                    <i class="fa-solid fa-calendar-days"></i>
                    <b>${formatearFecha(foro.fecha_creacion)}</b>
                    <span>Creado</span>
                </div>

            </div>

            <div class="sobre-card creador-card">

                <h3>
                    <i class="fa-solid fa-user-group"></i>
                    Comunidad creada por
                </h3>

                <p>
                    <b>Parently</b> creó este espacio para que padres puedan compartir,
                    aprender y apoyarse mutuamente.
                </p>

            </div>

            <div class="sobre-card">

                <h3>
                    <i class="fa-solid fa-bullseye"></i>
                    Objetivo
                </h3>

                <p>
                    ${foro.objetivo || "Sin información"}
                </p>

            </div>

            <div class="sobre-card">

                <h3>
                    <i class="fa-solid fa-shield-heart"></i>
                    Normas de la comunidad
                </h3>

                <ul>

                ${
                    foro.reglas
                    ? foro.reglas.split("|")
                        .map(r => `
                            <li>
                                <i class="fa-solid fa-check"></i>
                                ${r}
                            </li>
                        `).join("")
                    : "<li>No hay reglas registradas</li>"
                }

                </ul>

            </div>

        </div>

        `;

    })
    .catch(err => console.error(err));

}

function formatearFecha(fecha){

    if(!fecha) return "-";


    const opciones = {
        year:"numeric",
        month:"long",
        day:"numeric"
    };


    return new Date(fecha).toLocaleDateString(
        "es-ES",
        opciones
    );

}

