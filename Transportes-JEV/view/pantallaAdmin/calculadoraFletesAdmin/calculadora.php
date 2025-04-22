<?php 
include "../../../controller/conexion.php";
session_start();

if (!isset($_SESSION['id_cargo']) || $_SESSION['id_cargo'] != 1) {
    header("location: ../../../index.html"); // Redirige
    exit;
}
?>

<script>
      // REVISAR. NO FUNCIONA COMO DEBE 
      // recarga automática
      if (performance.navigation.type === 2) { 
      location.reload();
      }
</script>

<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="estilos.css">

      <title>Calculadora de fletes</title>
   </head>
   
   <body>
      
      <!--=============== HEADER ===============-->
      <header class="header" id="header">
            <div class="header__container">
                  <a href="#" class="header__logo">
                        <span>Transportes JEV</span>
                  </a>
                  
                  <button class="header__toggle" id="header-toggle">
                        <i class="ri-menu-line"></i>
                  </button>
            </div>

            <div class="header__container_dos">
                  <a href="#" class="header__logo">
                  </a>
            </div> 
      </header>

      <!--=============== SIDEBAR ===============-->
      <nav class="sidebar" id="sidebar">
         <div class="sidebar__container">
            <div class="sidebar__user">
                  <div class="sidebar__img">
                  <img src="assets/img/perfil.png" alt="image">
                  </div>

                  <div class="sidebar__info">
                  <h3>Transportes JEV</h3>
                  <span>Jhonny Vegas</span><br>
                  <span class="sidebar__title_name">Admin: <?php echo $_SESSION['usuario']; ?></span>
                  </div>
            </div>

            <div class="sidebar__content">
                  <div>
                  <h3 class="sidebar__title">ADMIN</h3>

                  <div class="sidebar__list">

                        <a href="#" class="sidebar__link active-link">
                              <i class="ri-pie-chart-2-fill"></i>
                              <span>Calculadora de Fletes</span>
                        </a>

                        <a href="../navbarOptions/camionesRegistrados.php" class="sidebar__link">
                              <i class="ri-pie-chart-2-fill"></i>
                              <span>Camiones</span>
                        </a>
                        
                        <a href="../navbarOptions/fletesExistentes.php" class="sidebar__link">
                              <i class="ri-wallet-3-fill"></i>
                              <span>Fletes</span>
                        </a>

                        <a href="../navbarOptions/usuariosRegistrados.php" class="sidebar__link">
                              <i class="ri-calendar-fill"></i>
                              <span>Usuarios</span>
                        </a>

                        <a href="" class="sidebar__link">
                              <i class="ri-arrow-up-down-line"></i>
                              <span>Calendario</span>
                        </a>

                  </div>
                  </div>

                  <div>
                  <h3 class="sidebar__title">SETTINGS</h3>

                  <div class="sidebar__list">
                        <a href="#" class="sidebar__link">
                        <i class="ri-settings-3-fill"></i>
                        <span>Settings</span>
                        </a>

                        <a href="#" class="sidebar__link">
                        <i class="ri-mail-unread-fill"></i>
                        <span>Mensajes</span>
                        </a>

                        <a href="#" class="sidebar__link">
                        <i class="ri-notification-2-fill"></i>
                        <span>Notificaciones</span>
                        </a>
                  </div>
                  </div>
            </div>

            <div class="sidebar__actions">
                  <button>
                  <i class="ri-moon-clear-fill sidebar__link sidebar__theme" id="theme-button">
                        <span>Tema</span>
                  </i>
                  </button>

                  <a href="../../../controller/cerrarSesion.php">
                        <button class="sidebar__link">
                        <i class="ri-logout-box-r-fill"></i>
                        <span>Cerrar Sesión</span>
                        </button>
                  </a>
            </div>
         </div>
      </nav>

      <!--=============== MAIN ===============-->
      <section class="main container" id="main">

             <!-- 
            - # CALCULADORA DE FLETES
            -->
            <section class="calculadoraSection">
                  <form action="" method="POST" id="fleteForm">
                  <div class="calculadora-container">
                        <h1>Solicitud de Flete</h1>
                  
                        <!-- Origen y Destino -->
                        <div class="field-group">
                              <div class="field">

                              <div class="plus-iconDiv">
                              <a href="../calculadoraEdit/nuevoFlete.php">
                                    <ion-icon name="add-circle-outline" class="plus-icon"></ion-icon>
                              </a>                
                              <label for="origen">ORIGEN</label>
                              </div>
                              
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

                              <div class="plus-iconDiv">

                              <a href="../calculadoraEdit/nuevoFlete.php">
                                    <ion-icon name="add-circle-outline" class="plus-icon"></ion-icon>
                              </a> 
                              <label for="destino">DESTINO</label>
                              </div>
                              
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

                              <div class="plus-iconDiv">
                              <a href="../calculadoraEdit/nuevoCamion.php">
                              <ion-icon name="add-circle-outline" class="plus-icon"></ion-icon>
                              </a> 
                              
                              <label for="modelo_camion">MODELO DE CAMIÓN</label>
                              </div>

                              
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
                              
                        <div class="plus-iconDiv">
                              <a href="../calculadoraEdit/nuevoCamion.php">
                              <ion-icon name="add-circle-outline" class="plus-icon"></ion-icon>
                              </a> 
                              
                              <label for="modelo_camion">TIPO DE CAMIÓN</label>
                        </div>
                        
                              <select name="tipo_camion" id="tipo_camion">
                              <option value="" disabled selected>Tipo</option>
                              </select>
                        </div>
                        </div>
                  
                        <!-- Capacidad y Servicios -->
                        <div class="field-group">
                        <div class="field">

                        <div class="plus-iconDiv">
                              <a href="../calculadoraEdit/nuevoCamion.php">
                              <ion-icon name="add-circle-outline" class="plus-icon"></ion-icon>
                              </a> 
                              
                              <label for="modelo_camion">CAPACIDAD DE CAMIÓN</label>
                        </div>

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
      </section>

      <!--=============== NAVBAR JS ===============-->
      <script src="assets/js/main.js"></script>

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