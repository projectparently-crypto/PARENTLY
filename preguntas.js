function mostrarToastPregunta(msg) {
  let toast = document.getElementById('toast-preguntas');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast-preguntas';
    toast.className = 'toast-preguntas';
    document.body.appendChild(toast);
  }

  toast.textContent = msg;
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 2800);
}

function reaccionarPregunta(btn) {
  btn.disabled = true;

  fetch('reaccionar_pregunta.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      id_pregunta: btn.dataset.pregunta,
      tipo: btn.dataset.tipo,
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
      if (!data.ok) {
        mostrarToastPregunta(data.error || 'No se pudo reaccionar');
        btn.disabled = false;
        return;
      }

      btn.closest('.card-pregunta')
        .querySelectorAll('.btn-reaccion-pregunta')
        .forEach((b) => {
          b.querySelector('.cnt').textContent = data.conteos[b.dataset.tipo] ?? 0;
          b.disabled = false;
        });

      btn.classList.toggle('activa', data.activa);
      mostrarToastPregunta(data.activa ? 'Reaccion registrada' : 'Reaccion eliminada');
    })
    .catch((err) => {
      mostrarToastPregunta(err.message || 'Error de conexion');
      btn.disabled = false;
    });
}

function toggleMenuPregunta(id) {
  document.querySelectorAll('.dropdown-menu-pregunta').forEach((menu) => {
    if (menu.id !== 'menu-pregunta-' + id) {
      menu.classList.remove('show');
    }
  });

  const menu = document.getElementById('menu-pregunta-' + id);
  if (menu) {
    menu.classList.toggle('show');
  }
}

function toggleEditarPregunta(id) {
  const form = document.getElementById('editar-pregunta-' + id);
  if (form) {
    form.classList.toggle('show');
  }

  const menu = document.getElementById('menu-pregunta-' + id);
  if (menu) {
    menu.classList.remove('show');
  }
}

window.addEventListener('click', (event) => {
  if (!event.target.closest('.menu-pregunta')) {
    document.querySelectorAll('.dropdown-menu-pregunta').forEach((menu) => {
      menu.classList.remove('show');
    });
  }
});
