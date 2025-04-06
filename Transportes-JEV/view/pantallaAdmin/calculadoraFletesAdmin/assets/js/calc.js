// Función para actualizar el tipo de camión basado en el modelo seleccionado
function mostrarTipoyYCapacidad() {
    mostrarTipoCamion();
    mostrarCapacidadCamion();
}

function mostrarTipoCamion() {
    // Obtener el modelo seleccionado
    const modeloCamion = document.getElementById("modelo_camion").value;

    // Selector de tipo de camión
    const tipoCamionSelect = document.getElementById("tipo_camion");

    // Restablecer siempre las opciones del select antes de añadir nuevas
    tipoCamionSelect.innerHTML = '<option value="" disabled selected>Tipo</option>';

    if (modeloCamion) {
        // Enviar solicitud al servidor
        
        fetch("../../../../../controller/calculadoraActions/tipo_camion.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "modelo_camion=" + encodeURIComponent(modeloCamion)
        })
        .then(response => response.text()) // Obtener respuesta del servidor
        .then(data => {
            tipoCamionSelect.innerHTML += data; // Añadir las opciones dinámicamente
        })
        .catch(error => console.error("Error:", error));
    }
}


// Función para actualizar la capacidad del camión basado en el modelo seleccionado
function mostrarCapacidadCamion() {
    const modeloCamion = document.getElementById("modelo_camion").value;
    const capacidadCamionSelect = document.getElementById("capacidad_camion");

    // Restablecer las opciones, pero manteniendo la opción inicial
    capacidadCamionSelect.innerHTML = '<option value="" disabled selected>Capacidad</option>';

    if (modeloCamion) {
        // Hacer la solicitud al servidor
        fetch("../../../../../controller/calculadoraActions/capacidad_camion.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "modelo_camion=" + encodeURIComponent(modeloCamion)
        })
        .then(response => response.text())
        .then(data => {
            capacidadCamionSelect.innerHTML += data; // Agregar las nuevas opciones dinámicas
        })
        .catch(error => console.error("Error:", error));
    }
}

/*--------------------------------------------------*/
/* Prevenir el envío si algún campo está incompleto */
/*--------------------------------------------------*/

document.getElementById("fleteForm").addEventListener("submit", function (event) {
  // Obtener los valores seleccionados
  const origen = document.getElementById("origen").value;
  const destino = document.getElementById("destino").value;
  const modeloC = document.getElementById("modelo_camion").value;
  const tipoC = document.getElementById("tipo_camion").value;
  const capacidadC = document.getElementById("capacidad_camion").value;
  const servicios = document.getElementById("servicios").value;
  const caleteros = document.getElementById("num_caleteros").value;

  // Div donde se muestran los errores
  const camposIncompletosDiv = document.getElementById("camposIncompletos-message");
  camposIncompletosDiv.innerHTML = ""; // Limpiar mensajes previos
  camposIncompletosDiv.style.display = "none"; // Ocultar el div al inicio

  // Verificar los campos uno por uno
  if (!origen) {
      camposIncompletosDiv.innerHTML = `<p>Debe seleccionar un origen</p>`;
      camposIncompletosDiv.style.display = "block"; // Mostrar el div si hay error
      event.preventDefault(); // Prevenir envío
      return; // Detener validación para mostrar solo este mensaje
  }
  if (!destino) {
      camposIncompletosDiv.innerHTML = `<p>Debe seleccionar un destino</p>`;
      camposIncompletosDiv.style.display = "block"; // Mostrar el div si hay error
      event.preventDefault();
      return;
  }
  if (!modeloC) {
      camposIncompletosDiv.innerHTML = `<p>Debe seleccionar un modelo de camión</p>`;
      camposIncompletosDiv.style.display = "block"; // Mostrar el div si hay error
      event.preventDefault();
      return;
  }
  if (!tipoC) {
      camposIncompletosDiv.innerHTML = `<p>Debe seleccionar un tipo de camión</p>`;
      camposIncompletosDiv.style.display = "block"; // Mostrar el div si hay error
      event.preventDefault();
      return;
  }
  if (!capacidadC) {
      camposIncompletosDiv.innerHTML = `<p>Debe seleccionar la capacidad del camión</p>`;
      camposIncompletosDiv.style.display = "block"; // Mostrar el div si hay error
      event.preventDefault();
      return;
  }
  if (!servicios) {
      camposIncompletosDiv.innerHTML = `<p>Debe seleccionar un servicio</p>`;
      camposIncompletosDiv.style.display = "block"; // Mostrar el div si hay error
      event.preventDefault();
      return;
  }
  if (!caleteros) {
      camposIncompletosDiv.innerHTML = `<p>Debe seleccionar el número de caleteros</p>`;
      camposIncompletosDiv.style.display = "block"; // Mostrar el div si hay error
      event.preventDefault();
      return;
  }

});

