<?php 
session_start();
include "../../../controller/conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcula tu flete</title>

    <!-- 
    - favicon
    -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

    <!-- 
        - custom css link
    -->
    <link rel="stylesheet" href="styles.css">

    <!--
    - google font link
    -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Rubik:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>
<body>

  <!-- 
  - # CALCULADORA DE FLETES
  -->
  <section class="calculadoraSection">
    <form action="../../../controller/actions.php" method="POST" id="fleteForm">
    <div class="calculadora-container">
      <h1>Solicitud de Flete</h1>
    
        <!-- Origen y Destino -->
        <div class="field-group">
            <div class="field">
                <label for="origen">ORIGEN</label>
                <select name="origen_viaje" id="origen">
                    <option value="" disabled selected>Origen</option>
                    <option value="Amazonas">Amazonas</option>
                    <option value="Anzoátegui">Anzoátegui</option>
                    <option value="Apure">Apure</option>
                    <option value="Aragua">Aragua</option>
                    <option value="Barinas">Barinas</option>
                    <option value="Bolívar">Bolívar</option>
                    <option value="Carabobo">Carabobo</option>
                    <option value="Cojedes">Cojedes</option>
                    <option value="Delta Amacuro">Delta Amacuro</option>
                    <option value="Distrito Capital">Distrito Capital</option>
                    <option value="Falcón">Falcón</option>
                    <option value="Guárico">Guárico</option>
                    <option value="Lara">Lara</option>
                    <option value="Mérida">Mérida</option>
                    <option value="Miranda">Miranda</option>
                    <option value="Monagas">Monagas</option>
                    <option value="Nueva Esparta">Nueva Esparta</option>
                    <option value="Portuguesa">Portuguesa</option>
                    <option value="Sucre">Sucre</option>
                    <option value="Táchira">Táchira</option>
                    <option value="Trujillo">Trujillo</option>
                    <option value="La Guaira">La Guaira</option>
                    <option value="Yaracuy">Yaracuy</option>
                    <option value="Zulia">Zulia</option>
                </select>
            </div>
            <div class="field">
                <label for="destino">DESTINO</label>
                <select name="destino_viaje" id="destino">
                    <option value="" disabled selected>Destino</option>
                    <option value="Amazonas">Amazonas</option>
                    <option value="Anzoátegui">Anzoátegui</option>
                    <option value="Apure">Apure</option>
                    <option value="Aragua">Aragua</option>
                    <option value="Barinas">Barinas</option>
                    <option value="Bolívar">Bolívar</option>
                    <option value="Carabobo">Carabobo</option>
                    <option value="Cojedes">Cojedes</option>
                    <option value="Delta Amacuro">Delta Amacuro</option>
                    <option value="Distrito Capital">Distrito Capital</option>
                    <option value="Falcón">Falcón</option>
                    <option value="Guárico">Guárico</option>
                    <option value="Lara">Lara</option>
                    <option value="Mérida">Mérida</option>
                    <option value="Miranda">Miranda</option>
                    <option value="Monagas">Monagas</option>
                    <option value="Nueva Esparta">Nueva Esparta</option>
                    <option value="Portuguesa">Portuguesa</option>
                    <option value="Sucre">Sucre</option>
                    <option value="Táchira">Táchira</option>
                    <option value="Trujillo">Trujillo</option>
                    <option value="La Guaira">La Guaira</option>
                    <option value="Yaracuy">Yaracuy</option>
                    <option value="Zulia">Zulia</option>
                </select>
            </div>
        </div>
    
        <!-- Modelo y Tipo de camión -->
        <div class="field-group">
          <div class="field">
            <label for="modelo_camion">MODELO DE CAMIÓN</label>
            <select name="modelo_camion" id="modelo_camion" onchange="mostrarTipoyYCapacidad()">
              <option value="" disabled selected>Modelo</option>

              <?php
              include "../../../controller/calculadoraActions/modelo_camion.php";
              while ($fila = mysqli_fetch_assoc($resultado)) {
                echo '<option value="' . htmlspecialchars($fila['modelo_camion']) . '">' . htmlspecialchars($fila['modelo_camion']) . '</option>';
              }
              ?>
                
            </select>
          </div>

          <div class="field">
            <label for="tipo_camion">TIPO DE CAMIÓN:</label>
            <select name="tipo_camion" id="tipo_camion">
              <option value="" disabled selected>Tipo</option>
            </select>
          </div>
        </div>
    
        <!-- Capacidad y Servicios -->
        <div class="field-group">
          <div class="field">
            <label for="capacidad_camion">CAPACIDAD DEL CAMIÓN:</label>
            <select name="capacidad_camion" id="capacidad_camion">
              <option value="" disabled selected>Capacidad</option>
            </select>
          </div>

          <div class="field">
            <label for="servicios">SERVICIOS:</label>
            <select name="servicios_viaje" id="servicios">
              <option value="transporte_refrigerado">Transporte Refrigerado</option>
              <option value="mudanza" selected>Mudanza</option>
              <option value="recoleccion_basura">Recolección basura</option>
              <option value="otro">Otro</option>
            </select>
          </div>
        </div>
    
        <!-- N° de Caleteros y Botón -->
        <div class="field-group">
          <div class="field">
            <label for="num_caleteros">N° DE CALETEROS:</label>
            <select name="caleteros_viaje" id="num_caleteros">
              <option value="1" selected>1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
            
          <div class="field">
            <label for="">-</label>
              <button type="submit" id="cotizar-flete">COTIZAR FLETE</button>
          </div>
        </div>

        <!-- Mensaje de error - Campos Incompletos-->
        <div id="camposIncompletos-message"></div>
    
        <?php
        if (isset($_SESSION['origen'], $_SESSION['destino'], $_SESSION['precio'])) {
            $origen = htmlspecialchars($_SESSION['origen']);
            $destino = htmlspecialchars($_SESSION['destino']);
            $precio = htmlspecialchars($_SESSION['precio']);
            //echo "El flete aproximado de $origen a $destino es de $precio."; ?>

            <div class="success-message">
              El flete aproximado de <?php echo $origen;?> a <?php echo $destino;?> es de <?php echo $precio;?>$. <a href="https://bit.ly/Transportes-JEV">Contáctanos</a>
            </div>

            <?php
            session_unset(); // Limpiar datos después de usarlos
            session_destroy();

        } else if (isset($_GET['whatsapp_url']) && isset($_GET['data']) && $_GET['data'] == 1) {
          
            $whatsapp_url = urldecode($_GET['whatsapp_url']); ?>
            
            <div class="data-message">
              <?php echo "El flete varía de acuerdo a sus necesidades <a href='$whatsapp_url'>Contáctanos para mayor información</a>"; ?> 
            </div>

        <?php
        } else if (isset($_GET['data']) && $_GET['data'] == 2) { ?>
          <div class="camposIncompletos-message">
            Ocurrió un error. Por favor, intente nuevamente
          </div>
        <?php
        
        } 
        ?>
     </div>

    <input type="hidden" name="hidden" value="4" />

    <?php
    // Cerrar la conexión
    mysqli_close($conex);
    ?>
    
    </form>
  </section>


  <!-- 
  - #FEATURE
  -->

  <section class="section feature" aria-label="feature">
    <div class="container">

      <div class="title-wrapper">

        <div>
          <p class="section-subtitle">¿Cómo trabajamos?</p>
          <h2 class="h2 section-title">Simple y efectivo en solo 3 pasos</h2>

          <!-- <p class="section-text">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry the standard dummy text ever
            since the when an
            printer took.
          </p> -->
        </div>

        <a href="#" class="btn">Subir</a>

      </div>

      <ul class="feature-list grid-list">
        <li>
          <div class="feature-card" style="--card-number: '01'">
            <div class="card-icon">
              <img src="./assets/img/feature-icon-1.png" width="72" height="91" alt="">
            </div>

            <h3 class="h3 card-title">Planificación y Organización</h3>
            <p class="card-text">
              Al ponerte en contacto con nosotros, analizamos tus necesidades, seleccionamos el transporte ideal 
              y planificamos la ruta más eficiente.</p>

            <a href="#" class="card-btn" aria-label="Read more">
              <ion-icon name="arrow-forward"></ion-icon>
            </a>
          </div>
        </li>

        <li>
          <div class="feature-card" style="--card-number: '02'">
            <div class="card-icon">
              <img src="./assets/img/feature-icon-2.png" width="94" height="94" alt="">
            </div>

            <h3 class="h3 card-title">Ejecución y Seguimiento</h3>
            <p class="card-text">
              Se realiza la carga, el transporte propiamente dicho y el monitoreo en tiempo real del envío. 
              Garantizando que el desarrollo siga lo establecido.
            </p>

            <a href="#" class="card-btn" aria-label="Read more">
              <ion-icon name="arrow-forward"></ion-icon>
            </a>

          </div>
        </li>

        <li>
          <div class="feature-card" style="--card-number: '03'">
            <div class="card-icon">
              <img src="./assets/img/feature-icon-3.png" width="93" height="93" alt="">
            </div>

            <h3 class="h3 card-title">Entrega y Evaluación</h3>
            <p class="card-text">
              La mercancía se entrega al destinatario final. Se evalúa el proceso para identificar áreas de mejora
              y se recoge retroalimentación del cliente.
            </p>

            <a href="#" class="card-btn" aria-label="Read more">
              <ion-icon name="arrow-forward"></ion-icon>
            </a>

          </div>
        </li>
      </ul>
    </div>
  </section>

    
  <!-- 
  - Javascript file 
  <script src="./assets/js/calc.js"></script> -->


  <!-- 
  - ionicon link
  -->

  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>




  <script>
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
            
            fetch("../../../controller/calculadoraActions/tipo_camion.php", {
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
            fetch("../../../controller/calculadoraActions/capacidad_camion.php", {
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
  </script>




</body>
</html>