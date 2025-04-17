<?php 
session_start();

if (!isset($_SESSION['id_cargo']) || $_SESSION['id_cargo'] != 1) {
    header("location: ../../../index.html"); // Redirige
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nuevo Flete</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>

    <main class="sign-up-mode">
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">


            <!-- Register Form -->
            <form action="../../../controller/actions.php" method="POST" autocomplete="off" class="sign-up-form" class="register-form formulario" id="formulario">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="easyclass" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Agrega un Nuevo Flete</h2>
                <h6>Datos del nuevo flete</h6>
              </div>

              <div class="actual-form">
                <!-- ORIGINAL
                <div class="input-wrap formulario__grupo formulario__grupo-input" id="grupo__nombre"> 
                  <input
                      type="text"
                      minlength="4"
                      class="input-field formulario__input"
                      autocomplete="off"
                      required
                      name="nombre"
                      id="nombre"
                  />
                  <p class="formulario__input-error">La contraseña tiene que ser de 4 a 12 dígitos.</p>
                  <label for="nombre" class="formulario__label">Nombre</label>              
                  <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div> -->


                <!-- Grupo: Origen -->
                <div class="input-wrap formulario__grupo" id="grupo__origen">
                  <div class="formulario__grupo-input">
                    <input 
                      type="text" 
                      class="input-field formulario__input" 
                      name="origen" 
                      id="origen" 
                      autocomplete="off"
                      required>
                  
                    <label for="origen" class="formulario__label">Origen</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El origen solo puede contener letras, espacios y acentos</p>
                </div>

                
                <!-- Grupo: Destino -->
                <div class="input-wrap formulario__grupo" id="grupo__destino">
                  <div class="formulario__grupo-input">
                    <input
                      type="text"
                      class="input-field formulario__input"
                      name="destino"
                      id="destino"
                      autocomplete="off"
                      required
                    />
                    <label for="destino" class="formulario__label">Destino</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El destino solo puede contener letras, espacios y acentos</p>
                </div>
        
                <!-- Grupo: Precio -->
                <div class="input-wrap formulario__grupo" id="grupo__capacidad">
                  <div class="formulario__grupo-input">
                    <input
                      type="text"
                      class="input-field formulario__input"
                      name="capacidad"
                      id="precio"
                      autocomplete="off"
                      required
                    />
                    <label for="precio" class="formulario__label">Precio</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El precio debe ser el número, sin puntos y sin símbolos</p> 
                  <!-- Mensaje de error | Da indicaciones para una capacidad correcta 
                  <p id="error-capacidadMessage"></p> -->
                </div>
       
                <!-- Mensajes del apartado - Nuevo Flete -->
                <?php if (isset($_GET['fleteExistente']) && $_GET['fleteExistente'] == 0) { ?>
                  <div class="failed-registration-message">
                    Flete existente
                  </div>
                <?php } ?>

                <?php if (isset($_GET['errorF']) && $_GET['errorF'] == 1) { ?>
                  <div class="failed-registration-message">
                    Asegúrate de completar correctamente los campos antes de enviar
                  </div>
                <?php } ?>

                <?php if (isset($_GET['errorF']) && $_GET['errorF'] == 2) { ?>
                  <div class="failed-registration-message">
                    ¡Ups! Ocurrió un problema. Intenta nuevamente
                  </div>
                <?php } ?>

                <?php if (isset($_GET['error']) && $_GET['error'] == "stmt_failed") { ?>
                  <div class="failed-registration-message">
                    Error en consulta. Intenta nuevamente
                  </div>
                <?php } ?>

                <?php if (isset($_GET['success']) && $_GET['success'] == 3) { ?>
                  <div class="success-message">
                    Flete agregado
                  </div>
                <?php } ?>

                <!-- Mensajes de error de campos -->
                <div id="error-camposMessage" class="error-camposMessage" style="display: none;"></div>

                <input type="hidden" name="hidden" value="5" />
                <input type="submit" class="sign-btn" value="Agregar Flete" />

                <p class="text">
                  Cuidamos cada kilómetro de tu carga.
                  <!-- <a href="#">Terms of Services</a> and
                  <a href="#">Privacy Policy</a> -->
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
    <script src="./assets/js/script.js"></script>

    <!-- Iconos de Font Awesome-->
    <script src="https://kit.fontawesome.com/c182496823.js" crossorigin="anonymous"></script>
  
    <!-- Iconos de Ionic-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  </body>
</html>
