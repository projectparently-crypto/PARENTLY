document.addEventListener("DOMContentLoaded", () => {

    const formulario = document.getElementById("formRespuesta");

    if (!formulario) {
        console.error("No existe el formulario #formRespuesta");
        return;
    }

    formulario.addEventListener("submit", function (e) {

        e.preventDefault();

        const boton = document.getElementById("btnResponder");

        if (boton) {
            boton.disabled = true;
            boton.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                Comparando tu respuesta...
            `;
        }

        const datos = new FormData(formulario);

        fetch("guardar_respuesta.php", {
            method: "POST",
            body: datos
        })

        .then(response => {

            if (!response.ok) {
                throw new Error("Error HTTP " + response.status);
            }

            return response.json();

        })

 .then(data => {

    console.log(data);

    if (!data.success) {

        alert(data.mensaje);

        if (boton) {
            boton.disabled = false;
            boton.innerHTML = "Responder";
        }

        return;
    }

    // Cambiar el botón cuando la respuesta se guardó
    if (boton) {
        boton.innerHTML = `
            <i class="fa-solid fa-check"></i>
            Respuesta enviada
        `;
    }

    const mensaje = document.getElementById("mensajeRespuesta");

    if (mensaje) {

        mensaje.classList.remove("d-none");

        setTimeout(() => {

        mensaje.classList.add("d-none");

        mostrarReflexion(data);

        }, 2000);

    } else {

        cargarResultados();

    }

})

        .catch(error => {

            console.error(error);

            alert("Ocurrió un error al guardar la respuesta.");

            if (boton) {
                boton.disabled = false;
                boton.innerHTML = "Responder";
            }

        });

    });

});

function cargarResultados(){

    const id = document.querySelector("[name=id_situacion]").value;

    fetch("obtener_resultados.php?id_situacion=" + id)

    .then(response => response.json())

    .then(datos => {

        const resultados = document.getElementById("resultados");

        resultados.classList.remove("d-none");

        let html = "<h2>📊 ¿Cómo respondió la comunidad?</h2>";

        datos.forEach((opcion,index)=>{

            html += `

            <div class="barra">

                <span>${opcion.texto}</span>

                <div class="progress">

                    <div
                        class="progress-bar barra${(index%4)+1}"
                        style="width:0%"
                        data-width="${opcion.porcentaje}">
                    </div>

                </div>

                <small>${opcion.porcentaje}%</small>

            </div>

            `;

        });

        resultados.innerHTML = html;

        setTimeout(()=>{

            document.querySelectorAll(".progress-bar").forEach(barra=>{

                barra.style.width = barra.dataset.width + "%";

            });

        },300);

        resultados.scrollIntoView({
            behavior:"smooth"
        });

    })

    .catch(error=>{

        console.error(error);

    });

}

function mostrarReflexion(data){

    const card = document.getElementById("reflexion");

    const icono = document.getElementById("iconoReflexion");

    const titulo = document.getElementById("tituloReflexion");

    const texto = document.getElementById("textoReflexion");

    card.classList.remove("d-none");

    if(data.recomendada==1){

        icono.innerHTML="🌟";

        titulo.innerHTML="¡Muy buena estrategia!";

    }else{

        icono.innerHTML="🧠";

        titulo.innerHTML="Reflexionemos juntos";

    }

    texto.innerHTML=

    "<strong>Elegiste:</strong> "+data.texto+

    "<br><br>"+

    data.explicacion;

    document

    .getElementById("btnVerResultados")

    .onclick=function(){

        card.classList.add("d-none");

        cargarResultados();

    };

}