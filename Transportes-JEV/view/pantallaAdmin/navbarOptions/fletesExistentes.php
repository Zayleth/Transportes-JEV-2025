<?php 
include "../../../controller/conexion.php";
session_start();

if (!isset($_SESSION['id_cargo']) || $_SESSION['id_cargo'] != 1) {
    header("location: ../../../index.html"); // Redirige
    exit;
}
?>

<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="style.css">

      <title>Fletes Existentes</title>
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
                        
                        <a href="../calculadoraFletesAdmin/calculadora.php" class="sidebar__link">
                              <i class="ri-pie-chart-2-fill"></i>
                              <span>Calculadora de Fletes</span>
                        </a>
                  
                        <a href="camionesRegistrados.php" class="sidebar__link">
                              <i class="ri-pie-chart-2-fill"></i>
                              <span>Camiones</span>
                        </a>
                        
                        <a href="fletesExistentes.php" class="sidebar__link active-link">
                              <i class="ri-wallet-3-fill"></i>
                              <span>Fletes</span>
                        </a>

                        <a href="usuariosRegistrados.php" class="sidebar__link">
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

            <?php
            $queryFletes = "SELECT * FROM viajes"; 
            $stmt = $conex->prepare($queryFletes);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <main class="table" id="customers_table">
                  
                  <section class="table__header">
                        <h1>Fletes Existentes</h1>
                        <div class="input-group">
                        <input type="search" placeholder="Buscar">
                        <img src="images/search.png" alt="">
                        </div>
                        <div class="export__file">
                        <label for="export-file" class="export__file-btn" title="Export File"></label>
                        <input type="checkbox" id="export-file">
                        <div class="export__file-options">
                              <label>Export As &nbsp; &#10140;</label>
                              <label for="export-file" id="toPDF">PDF <img src="images/pdf.png" alt=""></label>
                              <label for="export-file" id="toEXCEL">EXCEL <img src="images/excel.png" alt=""></label>
                        </div>
                        </div>
                  </section>


                  <section class="table__body">
                        <table>
                              <thead>
                              <tr>
                                    <th> Id </th>
                                    <th> Referencia </th>
                                    <th> Origen </th>
                                    <th> Destino </th>
                                    <th> Precio <span class="icon-arrow">&UpArrow;</span></th> 
                                    <th> Editar </th>
                                    <th> Eliminar </th>
                              </tr>
                              </thead>

                              <tbody>
                              <?php while ($row = $result->fetch_assoc()) { ?>
                              <tr>
                                    <td><?php echo $row['id_viaje']; ?></td>
                                    <td><img src="./images/fleteExistente.png" alt="Ruta"></td>
                                    <td><?php echo $row['origen_viaje']; ?></td>
                                    <td><?php echo $row['destino_viaje']; ?></td>
                                    <td><?php echo $row['precio_viaje'] ."$"; ?></td>

                                    <td>
                                          <div class="table-icon">
                                                <a href="./editarC-F-U/editarFlete.php?id=<?php echo $row['id_viaje']; ?>">
                                                      <ion-icon name="create-outline"></ion-icon>
                                                </a>
                                          </div>
                                    </td>

                                    <td>
                                          <form action="../../../controller/actions.php" method="POST" onsubmit="return confirmarEliminacionFlete()">
                                                <input type="hidden" name="hidden" value="10">
                                                <input type="hidden" name="id_fleteEliminar" value="<?php echo $row['id_viaje']; ?>">

                                                <button type="submit" class="table-icon">
                                                      <ion-icon name="trash-outline"></ion-icon>
                                                </button> 
                                          </form>

                                    </td>

                                    <script>
                                          function confirmarEliminacionFlete() {
                                                return confirm("¿Deseas eliminar este flete?");
                                          }
                                    </script>
                                    
                              </tr>
                              <?php } ?>
                              </tbody>
                        </table>
                  </section>


            </main>
            <script src="./assets/js/tablas_script.js"></script>
      </section>

      <!--=============== MAIN JS ===============-->
      <script src="assets/js/main.js"></script>

      <!-- 
      - ionicon link
      -->
      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
      
   </body>
</html>