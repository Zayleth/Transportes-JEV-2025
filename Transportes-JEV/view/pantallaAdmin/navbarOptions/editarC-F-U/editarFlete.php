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
    <title>Editar Flete</title>
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

            $queryFlete = "SELECT * FROM viajes WHERE id_viaje = ?";
            $stmt = $conex->prepare($queryFlete);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Guardar todos los datos en un array
            $consulta = $result->fetch_all(MYSQLI_ASSOC);
            ?>
            
            <div class="title-table">
                <p>
                    <?php echo "Flete: " . $consulta[0]['origen_viaje'] . " - " . $consulta[0]['destino_viaje']; ?>
                </p>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consulta as $fila) { ?>
                        <tr>
                            <td><?php echo $fila['id_viaje']; ?></td>
                            <td><?php echo $fila['origen_viaje']; ?></td>
                            <td><?php echo $fila['destino_viaje']; ?></td>
                            <td><?php echo $fila['precio_viaje']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
          </div>
      
        
          <div class="forms-wrap">
            <!-- Nuevo Flete Form -->
            <form action="../../../../controller/actions.php" method="POST" autocomplete="off" class="sign-up-form" class="register-form formulario" id="formulario">
              <div class="logo">
                <img src="./assets/img/logo.png" alt="easyclass" />
                <h4>Transportes JEV</h4>
              </div>

              <div class="heading">
                <h2>Editar Flete</h2>
                <h6></h6>
              </div>

              <div class="actual-form">
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
                  <p class="formulario__input-error">El precio debe ser el número, sin puntos y sin texto</p> 
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
                
                <input type="hidden" name="id_flete" value="<?php echo $id; ?>">
                <input type="hidden" name="hidden" value="9" />
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
