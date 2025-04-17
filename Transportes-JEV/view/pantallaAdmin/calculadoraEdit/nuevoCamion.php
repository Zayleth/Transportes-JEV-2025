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
    <title>Nuevo Camión</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>

    <main class="sign-up-mode">
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">


            <!-- Nuevo Camión Form -->
            <form action="../../../controller/actions.php" method="POST" autocomplete="off" class="sign-up-form" class="register-form formulario" id="formulario">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="easyclass" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Agrega un Nuevo Camión</h2>
                <h6>Largos trayectos y nuevas oportunidades</h6>
              </div>

              <div class="actual-form">
                <!-- Grupo: Modelo de Camion -->
                <div class="input-wrap formulario__grupo" id="grupo__origen">
                  <div class="formulario__grupo-input">
                    <input 
                      type="text" 
                      class="input-field formulario__input" 
                      name="origen" 
                      id="modelo" 
                      autocomplete="off"
                      required>
                  
                    <label for="modelo" class="formulario__label">Modelo</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El modelo solo puede contener letras, espacios y acentos</p>
                </div>

                
                <!-- Grupo: Tipo -->
                <div class="input-wrap formulario__grupo" id="grupo__destino">
                  <div class="formulario__grupo-input">
                    <input
                      type="text"
                      class="input-field formulario__input"
                      name="destino"
                      id="tipo"
                      autocomplete="off"
                      required
                    />
                    <label for="tipo" class="formulario__label">Tipo</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El tipo solo puede contener letras, espacios y acentos</p>
                </div>
        
                <!-- Grupo: Capacidad -->
                <div class="input-wrap formulario__grupo" id="grupo__capacidad">
                  <div class="formulario__grupo-input">
                    <input
                      type="text"
                      class="input-field formulario__input"
                      name="capacidad"
                      id="capacidad"
                      autocomplete="off"
                      required
                    />
                    <label for="capacidad" class="formulario__label">Capacidad</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">La capacidad debe ser el número, sin puntos y sin texto</p> 
                  <!-- Mensaje de error | Da indicaciones para una capacidad correcta 
                  <p id="error-capacidadMessage"></p> -->
                </div>
       
                <!-- Mensajes del apartado - Nuevo Camión -->
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

                <?php if (isset($_GET['success']) && $_GET['success'] == 3) { ?>
                  <div class="success-message">
                    Camión agregado correctamente
                  </div>
                <?php } ?>

                <!-- Mensajes de error de campos -->
                <div id="error-camposMessage" class="error-camposMessage" style="display: none;"></div>

                <input type="hidden" name="hidden" value="6" />
                <input type="submit" class="sign-btn" value="Agregar" />

                <p class="text">
                  Un motor que impulsa tus proyectos y fortalece tu visión ¡Felicidades!
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
