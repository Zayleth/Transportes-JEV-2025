<?php 
include "../../../../controller/conexion.php";
session_start();

if (!isset($_SESSION['id_cargo']) || $_SESSION['id_cargo'] != 1) {
    header("location: ../../../../index.html"); // Redirige
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>

    <main class="sign-up-mode">
      <div class="box">
        <div class="inner-box">
          
          <div class="carousel">
            
            <?php
            // Obtener el id_camion desde la URL
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Convierte a número para seguridad

            $queryFlete = "SELECT * FROM usuarios WHERE id_usuario = ?";
            $stmt = $conex->prepare($queryFlete);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Guardar todos los datos en un array
            $consulta = $result->fetch_all(MYSQLI_ASSOC);
            ?>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consulta as $fila) { ?>
                        <tr>
                            <td><?php echo $fila['id_usuario']; ?></td>
                            <td><?php echo $fila['nombre_usuario']; ?></td>
                            <td><?php echo $fila['correo_usuario']; ?></td>
                            <td><?php echo $fila['id_cargo']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
          </div>
      
        
          
          <div class="forms-wrap">
            <!-- Nuevo Camión Form -->
            <form action="../../../../controller/actions.php" method="POST" autocomplete="off" class="sign-up-form" class="register-form formulario">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="easyclass" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Editar Usuario</h2>
                <h6></h6>
              </div>

              <div class="actual-form">
                <!-- Grupo: Nuevo Nombre de Usuario -->
                <div class="input-wrap formulario__grupo">
                  <div class="formulario__grupo-input">
                    <input 
                    type="text" 
                    minlength="2" 
                    maxlength="30" 
                    class="input-field formulario__input" 
                    name="nuevo_nombre_user" 
                    id="nuevo_nombre_user" 
                    autocomplete="off"
                    required
                    />
                    <label for="nuevo_nombre_user" class="formulario__label">Nombre</label>
                  </div>
                </div>

                <script>
                  document.getElementById("nuevo_nombre_user").addEventListener("input", function() {
                    if (this.value.length < 2) {
                        this.setCustomValidity("Debe contener al menos 2 caracteres.");
                    } else {
                        this.setCustomValidity(""); // Limpia el mensaje si es válido
                    }
                  });

                </script>

                <!-- Grupo: Status -->
                <div class="input-wrap formulario__grupo">
                  <div class="formulario__grupo-input">
                    <select name="nuevo_cargo" id="nuevo_cargo">
                      <option value="" SELECTED DISABLED>Cargo</option>
                      <option value="1">1. Administrador</option>
                      <option value="2">2. Cliente</option>
                      <option value="3">3. Otro</option>
                    </select>
                    <label for="nuevo_cargo"></label>
                  </div>
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

                <!-- Mensajes de error de campos -->
                <div id="error-camposMessage" class="error-camposMessage" style="display: none;"></div>
                
                <input type="hidden" name="id_usuario" value="<?php echo $id; ?>">
                <input type="hidden" name="hidden" value="11" />
                <input type="submit" class="sign-btn" value="Actualizar" />

                <p class="text">
                  Asegúrate de completar correctamente los campos antes de enviar
                </p>
              </div>
            </form>

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
