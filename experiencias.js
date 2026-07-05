// experiencias.js — Parently
// Reacciones y comentarios sin recargar la página

document.querySelectorAll(".categoria-btn").forEach(btn=>{

    btn.addEventListener("click",function(){

        document.querySelectorAll(".categoria-btn").forEach(b=>b.classList.remove("active"));

        this.classList.add("active");

        document.getElementById("id_categoria").value=this.dataset.id;

    });

});


document.querySelectorAll(".categoria-item").forEach(item=>{

    item.addEventListener("click",function(e){

        e.preventDefault();

        document.getElementById("id_categoria").value=this.dataset.id;

        document.querySelectorAll(".categoria-btn").forEach(b=>b.classList.remove("active"));

        document.querySelector(".dropdown-toggle").innerHTML=this.innerHTML;

    });

});

// ── TOAST ─────────────────────────────────────────────────
function mostrarToast(msg) {
  const t = document.getElementById('toast');
  if (!t) return;
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3200);
}

// ── REACCIONAR ─────────────────────────────────────────────
function reaccionar(btn) {
  btn.disabled = true;

  const id_experiencia = btn.dataset.exp;
  const tipo           = btn.dataset.tipo;

  fetch('reaccionar.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({ id_experiencia, tipo }),
  })
  .then(r => {
    if (!r.ok) throw new Error('HTTP ' + r.status);
    return r.json();
  })
  .then(data => {
    if (!data.ok) {
      mostrarToast('⚠️ ' + (data.error || 'Error al registrar reacción'));
      btn.disabled = false;
      return;
    }
    // Actualizar conteos de los 3 botones de esa tarjeta
    btn.closest('.card-experiencia')
       .querySelectorAll('.btn-reaccion')
       .forEach(b => {
         b.querySelector('.cnt').textContent = data.conteos[b.dataset.tipo] ?? 0;
         b.disabled = false;
       });
    btn.classList.toggle('activa', data.activa);
    mostrarToast(data.activa ? '¡Reacción registrada! 🙏' : 'Reacción eliminada');
  })
  .catch(err => {
    mostrarToast('❌ Error de conexión');
    btn.disabled = false;
  });
}

// ── TOGGLE COMENTARIOS ─────────────────────────────────────
const _comsYaCargados = {};

function toggleComentarios(btn, id_experiencia) {
  const box   = document.getElementById('coms-' + id_experiencia);
  const lista = document.getElementById('lista-' + id_experiencia);
  const abierto = box.classList.toggle('abierto');

  if (abierto && !_comsYaCargados[id_experiencia]) {
    _comsYaCargados[id_experiencia] = true;
    lista.innerHTML = '<p class="sin-comentarios">Cargando...</p>';

    fetch('comentarios_experiencias.php?id_experiencia=' + encodeURIComponent(id_experiencia))
      .then(r => {
        // Leer como texto primero para detectar errores HTML
        return r.text().then(txt => {
          try {
            return JSON.parse(txt);
          } catch {
            console.error('Respuesta no es JSON:', txt);
            throw new Error('El servidor no devolvió JSON');
          }
        });
      })
      .then(data => {
        lista.innerHTML = '';
        if (!data.ok) {
          lista.innerHTML = '<p class="sin-comentarios">⚠️ ' + escHtml(data.error || 'Error al cargar') + '</p>';
          return;
        }
        if (!data.comentarios.length) {
          lista.innerHTML = '<p class="sin-comentarios">Sé el primero en comentar 💬</p>';
        } else {
          data.comentarios.forEach(c => agregarComentarioDOM(lista, c));
        }
        _actualizarContadorBtn(btn, lista);
      })
      .catch(err => {
        lista.innerHTML = '<p class="sin-comentarios">❌ ' + escHtml(err.message) + '</p>';
      });
  }
}

// ── ENVIAR COMENTARIO ──────────────────────────────────────
// Guardamos el nombre elegido durante la sesión de navegación
let _nombreElegido = null;

function enviarComentario(id_experiencia) {
  const inp    = document.getElementById('inp-com-' + id_experiencia);
  const texto  = inp.value.trim();

  if (!texto) {
    mostrarToast('Escribe algo antes de enviar 📝');
    return;
  }

  // Si ya eligió nombre, mandar directo
  if (_nombreElegido !== null) {
    _postComentario(id_experiencia, inp, _nombreElegido);
    return;
  }

  // Si no, mostrar modal de elección de nombre
  _abrirModalNombre(function(nombreElegido) {
    _nombreElegido = nombreElegido;
    _postComentario(id_experiencia, inp, _nombreElegido);
  });
}

function _postComentario(id_experiencia, inp, nombre) {
  const texto = inp.value.trim();
  if (!texto) return;

  const btn = inp.nextElementSibling; // botón Enviar
  inp.disabled = true;
  btn.disabled = true;

  fetch('comentarios.php', {
    method:  'POST',
    headers: { 'Content-Type': 'application/json' },
    body:    JSON.stringify({
      id_experiencia,
      nombre_usuario: nombre,
      comentario:     texto,
    }),
  })
  .then(r => r.text().then(txt => {
    try { return JSON.parse(txt); }
    catch { throw new Error('Respuesta inválida del servidor'); }
  }))
  .then(data => {
    inp.disabled = false;
    btn.disabled = false;

    if (!data.ok) {
      mostrarToast('⚠️ ' + (data.error || 'No se pudo enviar'));
      return;
    }

    const lista = document.getElementById('lista-' + id_experiencia);

    // Quitar mensaje "sé el primero"
    const placeholder = lista.querySelector('.sin-comentarios');
    if (placeholder) placeholder.remove();

    agregarComentarioDOM(lista, data);
    inp.value = '';

    // Actualizar contador del botón
    const btnComs = document.querySelector(
      `[onclick="toggleComentarios(this, ${id_experiencia})"]`
    );
    if (btnComs) _actualizarContadorBtn(btnComs, lista);

    mostrarToast('¡Comentario publicado! 💬');
  })
  .catch(err => {
    inp.disabled = false;
    btn.disabled = false;
    mostrarToast('❌ ' + err.message);
  });
}

// ── MODAL DE NOMBRE ────────────────────────────────────────
function _abrirModalNombre(callback) {
  const modal    = document.getElementById('modal-nombre');
  const bsModal  = new bootstrap.Modal(modal, { backdrop: 'static', keyboard: false });

  const btnNombre   = document.getElementById('modal-btn-nombre');
  const btnAnonimo  = document.getElementById('modal-btn-anonimo');
  const inputNombre = document.getElementById('modal-input-nombre');

  // Precargar nombre de sesión si viene del servidor
  const nombreSesion = window.PARENTLY_USER || '';
  if (nombreSesion) inputNombre.value = nombreSesion;

  // Limpiar listeners previos clonando
  const btnN2 = btnNombre.cloneNode(true);
  const btnA2 = btnAnonimo.cloneNode(true);
  btnNombre.parentNode.replaceChild(btnN2, btnNombre);
  btnAnonimo.parentNode.replaceChild(btnA2, btnAnonimo);

  document.getElementById('modal-btn-nombre').addEventListener('click', () => {
    const nombre = document.getElementById('modal-input-nombre').value.trim();
    if (!nombre) {
      document.getElementById('modal-input-nombre').focus();
      document.getElementById('modal-input-nombre').style.borderColor = '#dc3545';
      return;
    }
    bsModal.hide();
    callback(nombre);
  });

  document.getElementById('modal-btn-anonimo').addEventListener('click', () => {
    bsModal.hide();
    callback('Anónimo');
  });

  bsModal.show();
}

// ── HELPERS ────────────────────────────────────────────────
function agregarComentarioDOM(lista, c) {
  const nombre = c.nombre_usuario || 'Anónimo';
  const ini    = nombre.charAt(0).toUpperCase();
  const div    = document.createElement('div');
  div.className = 'comentario';
  div.style.animation = 'fadeUp .3s ease both';
  div.innerHTML = `
    <div class="av-mini">${escHtml(ini)}</div>
    <div class="com-body">
      <span class="com-autor">${escHtml(nombre)}</span>
      <span class="com-fecha">${escHtml(c.fecha || '')}</span>
      <p class="com-texto">${escHtml(c.comentario)}</p>
    </div>`;
  lista.appendChild(div);
}

function _actualizarContadorBtn(btn, lista) {
  const total = lista.querySelectorAll('.comentario').length;
  const span  = btn.querySelector('span');
  if (span) span.textContent = total + ' comentario' + (total !== 1 ? 's' : '');
}

function escHtml(str) {
  return String(str || '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function toggleMenu(id){

    document.querySelectorAll(".dropdown-menu-exp").forEach(menu=>{

        if(menu.id!="menu-"+id){

            menu.classList.remove("show");

        }

    });

    document
        .getElementById("menu-"+id)
        .classList
        .toggle("show");

}

window.onclick=function(e){

    if(!e.target.closest(".menu-exp")){

        document
            .querySelectorAll(".dropdown-menu-exp")
            .forEach(menu=>{

                menu.classList.remove("show");

            });

    }

}

function copiarLink(id){

    navigator.clipboard.writeText(

        location.origin+

        "/foro.php?id="+id

    );

    alert("Enlace copiado.");

}

function enviarComentario(id_experiencia) {
  const inp = document.getElementById('inp-com-' + id_experiencia);
  const texto = inp.value.trim();

  if (!texto) {
    mostrarToast('Escribe algo antes de enviar');
    return;
  }

  if (_nombreElegido === null) {
    _nombreElegido = window.PARENTLY_USER || 'Anonimo';
  }

  _postComentario(id_experiencia, inp, _nombreElegido);
}

function _postComentario(id_experiencia, inp, nombre) {
  const texto = inp.value.trim();
  const btn = inp.nextElementSibling;

  if (!texto) return;

  inp.disabled = true;
  if (btn) btn.disabled = true;

  fetch('comentarios_experiencias.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      id_experiencia,
      nombre_usuario: nombre,
      comentario: texto,
    }),
  })
    .then((r) => r.text())
    .then((txt) => {
      try {
        return JSON.parse(txt);
      } catch {
        throw new Error('Respuesta invalida del servidor');
      }
    })
    .then((data) => {
      inp.disabled = false;
      if (btn) btn.disabled = false;

      if (!data.ok) {
        mostrarToast(data.error || 'No se pudo enviar');
        return;
      }

      const lista = document.getElementById('lista-' + id_experiencia);
      const placeholder = lista.querySelector('.sin-comentarios');
      if (placeholder) placeholder.remove();

      agregarComentarioDOM(lista, data);
      inp.value = '';

      const btnComs = document.querySelector(
        `[onclick="toggleComentarios(this, ${id_experiencia})"]`
      );
      if (btnComs) _actualizarContadorBtn(btnComs, lista);

      mostrarToast('Comentario publicado');
    })
    .catch((err) => {
      inp.disabled = false;
      if (btn) btn.disabled = false;
      mostrarToast(err.message || 'Error de conexion');
    });
}
