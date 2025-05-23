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
    <title>Editar Camión</title>
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

            $queryCamion = "SELECT * FROM camiones WHERE id_camion = ?";
            $stmt = $conex->prepare($queryCamion);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Guardar todos los datos en un array
            $consulta = $result->fetch_all(MYSQLI_ASSOC);
            ?>
            
            <div class="title-table">
                <p>
                    <?php echo "Modelo del camión: " . $consulta[0]['modelo_camion']; ?>
                </p>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Modelo</th>
                            <th>Tipo</th>
                            <th>Capacidad</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consulta as $fila) { ?>
                        <tr>
                            <td><?php echo $fila['id_camion']; ?></td>
                            <td><?php echo $fila['modelo_camion']; ?></td>
                            <td><?php echo $fila['tipo_camion']; ?></td>
                            <td><?php echo $fila['capacidad_camion']; ?></td>
                            <td><?php echo $fila['status_camion']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
          </div>
      
        
          <div class="forms-wrap">
            <!-- Nuevo Camión Form -->
            <form action="../../../../controller/actions.php" method="POST" autocomplete="off" class="sign-up-form" class="register-form formulario" id="formulario">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="easyclass" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Editar Camión</h2>
                <h6></h6>
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

                <!-- Grupo: Status -->
                <div class="input-wrap formulario__grupo">
                  <div class="formulario__grupo-input">
                    <select name="nuevo_status" id="nuevo_status">
                      <option value="" SELECTED DISABLED>Status</option>
                      <option value="Disponible">Disponible</option>
                      <option value="No disponible">No disponible</option>
                      <option value="Mantenimiento">Mantenimiento</option>
                    </select>
                    <label for="nuevo_status"></label>
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
                
                <input type="hidden" name="id_camion" value="<?php echo $id; ?>">
                <input type="hidden" name="hidden" value="7" />
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
