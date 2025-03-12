<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de Sesión & Registro</title>
    <link rel="stylesheet" href="styless.css" />
  </head>
  <body>

    <main>
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            
            <!-- Log In Form -->
            <form action="../../controller/actions.php" method="POST" autocomplete="off" class="sign-in-form">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="Transportes JEV" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>¡Nos encanta verte de regreso!</h2>
                <h6>¿Aún no estás registrado?</h6>
                <a href="#" class="toggle">Crea tu cuenta</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                      type="email"
                      minlength="8"
                      class="input-field"
                      name="correo"
                      id="correo_LogIn"
                      autocomplete="off"
                      required
                  />
                  <label>Correo</label>                  
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    minlength="8"
                    class="input-field"
                    name="password"
                    id="password-LogIn"
                    autocomplete="off"
                    required
                  />
                  <label>Contraseña</label>
                </div>
                
                <input type="hidden" name="hidden" value="2" />

                <?php if (isset($_GET['errorDatos']) && $_GET['errorDatos'] == 1) { ?>
                  <div class="failed-logIn-message">
                    Datos no encontrados. Verifique su correo o contraseña
                  </div>
                <?php } ?>

                <!--<input type="submit" value="Iniciar Sesión" class="sign-btn" /> -->
                <button type="submit" class="sign-btn">Iniciar Sesión</button>

                <p class="text">
                  ¿Problemas para ingresar? 
                  <a href="./assets/olvido_pass.php">Recupera tu acceso</a> 
                </p>
              </div>
            </form>

            <!-- Register Form -->
            <form action="../../controller/actions.php" method="POST" autocomplete="off" class="sign-up-form" class="register-form formulario" id="formulario">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="easyclass" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Regístrate aquí</h2>
                <h6>¿Ya tienes cuenta?</h6>
                <a href="#" class="toggle">Iniciar Sesión</a>
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


                <!-- Grupo: Nombre -->
                <div class="input-wrap formulario__grupo" id="grupo__nombre">
                  <div class="formulario__grupo-input">
                    <input 
                      type="text" 
                      class="input-field formulario__input" 
                      name="nombre" 
                      id="nombre" 
                      autocomplete="off"
                      required>
                  
                    <label for="nombre" class="formulario__label">Nombre</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">El nombre solo puede contener letras, espacios y acentos</p>
                </div>
             

                <!-- Grupo: Correo Electronico -->
                <div class="input-wrap formulario__grupo" id="grupo__correo">
                  <div class="formulario__grupo-input">
                    <input
                      type="email"
                      class="input-field formulario__input"
                      name="correo"
                      id="correo"
                      autocomplete="off"
                      required
                    />
                    <label for="correo" class="formulario__label">Correo</label>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  <p class="formulario__input-error">Ingrese un correo válido</p>

                  <!-- Div para mensaje de error - Correo existente -->
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
                    <label for="password" class="formulario__label">Contraseña</label>
                    <i class="fa-regular fa-eye" id="password-eye"></i>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                  </div>
                  
                  <!-- Mensaje de error | Da indicaciones para una correcta contraseña -->
                  <p class="formulario__input-error">
                    <p id="error-passwordMessage" class="error-passwordMessage" style="display: none;"></p>
                  </p>
                </div>

                <input type="hidden" name="hidden" value="1" />
       
              
                <?php if (isset($_GET['usuarioRegistrado']) && $_GET['usuarioRegistrado'] == 1) { ?>
                  <div class="success-message">
                    ¡Registro Exitoso! Ahora puedes iniciar sesión
                  </div>
                <?php } ?>

                <?php if (isset($_GET['errorRegistro']) && $_GET['errorRegistro'] == 2) { ?>
                  <div class="failed-registration-message">
                    ¡Ups! Registro fallido. Intenta nuevamente
                  </div>
                <?php } ?>

                <?php if (isset($_GET['errorRegistro']) && $_GET['errorRegistro'] == 3) { ?>
                  <div class="failed-registration-message">
                    Asegúrate de completar correctamente los campos antes de enviar
                  </div>
                <?php } ?>
                    
                <div id="error-camposMessage" class="error-camposMessage" style="display: none;"></div>
                <input type="submit" class="sign-btn" value="Registrar" />

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
    <script src="./assets/js/logIn.js"></script>

    <!-- Iconos de Font Awesome-->
    <script src="https://kit.fontawesome.com/c182496823.js" crossorigin="anonymous"></script>
  
    <!-- Iconos de Ionic-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  </body>
</html>
