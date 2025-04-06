<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de Sesión & Registro</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>

    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            
            <!-- Nuevo Flete Form -->
            <form action="../../../controller/actions.php" method="POST" autocomplete="off" class="sign-in-form" class="sign-up-form register-form formulario" id="formulario">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="Transportes JEV" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Agrega un Nuevo Flete</h2>
                <h6>Datos del nuevo flete</h6>
                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                <!--<a href="#" class="toggle">Crea tu cuenta</a>-->
              </div>

              <div class="actual-form">

                <!-- Grupo: Origen -->
                <div class="input-wrap formulario__grupo" id="grupo__nombre">
                  <div class="formulario__grupo-input">
                    <input 
                      type="text" 
                      class="input-field formulario__input" 
                      name="nuevoOrigen" 
                      id="nombre" 
                      autocomplete="off"
                      required>
                  
                    <label for="nombre" class="formulario__label">Origen</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El origen solo puede contener letras, espacios y acentos</p>
                </div>

                <!-- Grupo: Destino -->
                <div class="input-wrap formulario__grupo" id="grupo__nombre">
                  <div class="formulario__grupo-input">
                    <input 
                      type="text" 
                      class="input-field formulario__input" 
                      name="nuevoDestino" 
                      id="destino" 
                      autocomplete="off"
                      required>
                  
                    <label for="nombre" class="formulario__label">Destino</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El destino solo puede contener letras, espacios y acentos</p>
                
                  <!-- Div para mensaje de error - Flete existente -->
                  <?php 
                  if (isset($_GET['fleteExistente']) && $_GET['fleteExistente'] == 0) { ?>
                    <div class="error-message">
                      Flete existente
                    </div> 
                  <?php } 
                  ?>
                
                </div>


                <!-- Grupo: Precio -->
                <div class="input-wrap formulario__grupo" id="grupo__nombre">
                  <div class="formulario__grupo-input">
                    <input 
                      type="text" 
                      class="input-field formulario__input" 
                      name="nuevoPrecio" 
                      id="precio" 
                      autocomplete="off"
                      required>
                  
                    <label for="precio" class="formulario__label">Precio</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error" id="error-precioMessage">
                  </p>
                </div>
                
                <input type="hidden" name="hidden" value="5" />


                <!-- Mensajes del apartado - Nuevo Flete -->
                <!-- Mensaje campos vacios / formato de datos -->
                <?php if (isset($_GET['errorF']) && $_GET['errorF'] == 1) { ?>
                  <div class="failed-registration-message">
                    Asegúrate de completar correctamente los campos antes de enviar
                  </div>
                <?php } ?>

                <!-- Mensaje error de conexion -->
                <?php if (isset($_GET['errorF']) && $_GET['errorF'] == 2) { ?>
                  <div class="failed-registration-message">
                    Error de conexión. Intente en unos minutos
                  </div>
                <?php } ?>

                <!-- Mensaje de éxito -->
                <?php if (isset($_GET['success']) && $_GET['success'] == 3) { ?>
                  <div class="success-message">
                    Flete agregado correctamente
                  </div>
                <?php } ?>

                <!-- Mensaje error -->
                <?php if (isset($_GET['errorF']) && $_GET['errorF'] == 4) { ?>
                  <div class="failed-registration-message">
                    ¡Ups! Algo salió mal. Intenta nuevamente
                  </div>
                <?php } ?>

                <div id="error-camposMessage" class="error-camposMessage">
                </div>

                <button type="submit" class="sign-btn">Agregar Flete</button>

                <p class="text">
                  ¿Agregado correctamente? 
                  <a href="../calculadoraFletesAdmin/calculadora.php">Regresa</a> 
                </p>
              </div>
            </form>

          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img src="./assets/img/image1.png" class="image img-1 show" alt="" />
              <img src="./assets/img/image2.png" class="image img-2" alt="" />
              <img src="./assets/img/image3.png" class="image img-3" alt="" />
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                  <h2>En cada punto del país</h2>
                  <h2>Monitorea en tiempo real</h2>
                  <h2>¡Únete al equipo!</h2>
                </div>
              </div>

              <div class="bullets">
                <span class="active" data-value="1"></span>
                <span data-value="2"></span>
                <span data-value="3"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Javascript file -->
    <script src="./assets/js/funcionalidad.js"></script>

    
    <!-- Iconos de Font Awesome-->
    <script src="https://kit.fontawesome.com/c182496823.js" crossorigin="anonymous"></script>
  
    <!-- Iconos de Ionic-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  
  </body>
</html>
