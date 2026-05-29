let foros = [];
let actual = 1;

console.log(usuario);

/* FOROS */
fetch("get_foros.php")
.then(r => r.json())
.then(data => {
  foros = data;
  if (foros.length > 0) cargarForo(foros[0].id);
});

function cargarForo(id){
  actual = id;

  let f = foros.find(x => x.id == id);

  document.getElementById("foro-titulo").innerText = f.nombre;
  document.getElementById("foro-img").src = f.imagen;
  document.getElementById("miembros").innerText = f.miembros;

  cargarComentarios();
}

function unirse(){

  let btn = document.getElementById("btnUnirse");

  if(btn.innerText == "Unirse"){

    fetch("unirse.php", {
      method:"POST",
      headers:{"Content-Type":"application/json"},
      body:JSON.stringify({
        foro_id:actual,
        usuario
      })
    });

    btn.innerText = "Salir";

  }else{

    fetch("salirse.php", {
      method:"POST",
      headers:{"Content-Type":"application/json"},
      body:JSON.stringify({
        foro_id:actual,
        usuario
      })
    });

    btn.innerText = "Unirse";
  }

}
/* VERIFICAR */
function verificarUnion(cb){
  fetch("check_unido.php?foro_id="+actual)
  .then(r=>r.json())
  .then(cb);
}

/* PUBLICAR */
function publicar(){

  let texto = document.getElementById("inputComentario").value;

  if(texto.trim()==="")return;

  verificarUnion((ok)=>{

    if(!ok){
      alert("Debes unirte al foro");
      return;
    }

    fetch("comentarios.php",{
      method:"POST",
      headers:{"Content-Type":"application/json"},
      body:JSON.stringify({foro_id:actual,comentario:texto,usuario})
    })
    .then(()=>{
      document.getElementById("inputComentario").value="";
      cargarComentarios();
    });

  });
}

/* COMENTARIOS */
function cargarComentarios(){

  fetch("get_comentarios.php?foro_id="+actual)
  .then(r=>r.json())
  .then(data=>{

    let cont = document.getElementById("comentarios");
    cont.innerHTML="";

    data.forEach(c=>{
      cont.innerHTML+=`
        <div>
          <b>${c.usuario}</b>
          <p>${c.texto}</p>
          <button onclick="eliminarComentario(${c.id})">Eliminar</button>
        </div>
      `;
    });

  });

}

/* ELIMINAR */
function eliminarComentario(id){

  fetch("eliminar_comentario.php",{
    method:"POST",
    headers:{"Content-Type":"application/json"},
    body:JSON.stringify({id})
  })
  .then(()=>cargarComentarios());

}