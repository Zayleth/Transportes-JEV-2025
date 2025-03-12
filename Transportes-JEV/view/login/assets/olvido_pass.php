<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../styles.css" />
  </head>
  <body>

    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            
            <!-- Log In Form -->
            <form action="../../../controller/actions.php" method="POST" autocomplete="off" class="register-form formulario" id="formulario">
              <div class="logo">
                <img src="./img/logo.png" alt="Transportes JEV" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Cambia tu clave</h2>
                <h6>¿Recuperaste tu contraseña?</h6>
                <a href="../index.php" class="toggle">Inicia Sesión</a>
              </div>

              <div class="actual-form">
                <!-- Grupo: Correo Electronico -->
                <div class="input-wrap formulario__grupo" id="grupo__correo">
                  <div class="formulario__grupo-input">
                    <input
                      type="email"
                      class="input-field formulario__input"
                      name="correo" 
                      id="correo_LogIn"
                      autocomplete="off"
                      required
                    /> <!-- changed_correo -->

                    <label for="correo" class="formulario__label">Correo</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El correo debe ser válido</p>

                  <!-- Div para mensaje de error - No se encuentra el correo -->
                  <div class="error-message"></div>
                </div>


                <!-- Grupo: Contraseña -->
                <div class="input-wrap formulario__grupo" id="grupo__password">
                  <div class="formulario__grupo-input">
                    <input
                      type="password"
                      minlength="8"
                      class="input-field formulario__input"
                      name="password"
                      id="passwordRegister"
                      autocomplete="off"
                      required
                    />
                    <label for="passwordRegister" class="formulario__label">Nueva Contraseña</label>
                    <i class="fa-regular fa-eye" id="password-eye"></i>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">La contraseña debe contener mínimo 8 dígitos</p>
                </div>
                
                <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                  <div class="success-message">
                    Contraseña actualizada. Ahora puedes iniciar sesión
                  </div>
                <?php } ?>

                <?php if (isset($_GET['fallo']) && $_GET['fallo'] == 1) { ?>
                  <div class="failed-registration-message">
                    ¡Ups! Algo salió mal. Intenta nuevamente
                  </div>
                <?php } ?>

                <input type="hidden" name="hidden" value="3" />

                <?php if (isset($_GET['errorDatos']) && $_GET['errorDatos'] == 1) { ?>
                  <div class="failed-logIn-message">
                    Datos no encontrados. Verifique su correo o contraseña
                  </div>
                <?php } ?>

                <?php if (isset($_GET['error']) && $_GET['error'] == 2) { ?>
                  <div class="failed-logIn-message">
                    Correo no encontrado
                  </div>
                <?php } ?>

                
                <input type="hidden" name="hidden" value="3" />
                <!--<input type="submit" value="Iniciar Sesión" class="sign-btn" /> -->
                <button type="submit" class="sign-btn">Actualizar</button>
              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img src="../assets/img/image1.png" class="image img-1 show" alt="" />
              <img src="../assets/img/image2.png" class="image img-2" alt="" />
              <img src="../assets/img/image3.png" class="image img-3" alt="" />
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
    <script src="./js/logIn.js"></script>

    <!-- Iconos de Font Awesome-->
    <script src="https://kit.fontawesome.com/c182496823.js" crossorigin="anonymous"></script>
  
    <!-- Iconos de Ionic-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  </body>
</html>
