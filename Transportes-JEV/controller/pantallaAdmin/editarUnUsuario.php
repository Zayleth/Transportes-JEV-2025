<?php
session_start();
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/View/editarUnUsuario.css">
    <title>Editar caracteristicas Usuario</title>
</head>
<body>
    <div class="body-f">
    <div class="container">

        <?php
        $id_usuario = $_GET['id_usuario'];
        //$_SESSION['$id_usuario'] = $nuevoId;
        
        
        /*
        // traer los datos de la tabla camiones con id seleccionado
        $sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
        $resultado = mysqli_query($conex, $sql);

        if ($resultado) {
            if (mysqli_num_rows($resultado) > 0) {
                // Obtener la fila seleccionada
                $fila = mysqli_fetch_assoc($resultado);

                // creamos tabla
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "</tr>";

                echo "<th>ID</th>";
                echo "<th>Nombre</th>";
                echo "<th>Apellido</th>";
                echo "<th>Correo</th>";

                echo "</thead>";
                echo "<tbody>";


                echo "<tr>";   
                echo "<td>" . $fila['id_usuario'] . "</td>";   
                echo "<td>" . $fila['nombre_usuario'] . "</td>"; 
                echo "<td>" . $fila['apellido_usuario'] . "</td>";
                echo "<td>" . $fila['correo_usuario'] . "</td>";
                echo "</tr>";

                echo "</tbody>";
                echo "</table>";

            } else {
                echo "No se encontraron resultados.";
            }
        } else {
            echo "Error al ejecutar la consulta: " . mysqli_error($conex);
        }
        */


        ?>

        <!-- FORM PARA EDITAR DATOS -->
        
        <div class="form-container">
            <div class="form-col">
      
                <!--FORM-->
                <form class="form" action="actualizar_datos.php?id_usuario=<?php echo $id_usuario; ?>" method="POST">

                    <div class="form-title">
                        <span>Editar</span>
                    </div>

                    <div class="form-inputs">
                        <div class="input-box">
                            <label for="edit_nombre"></label>
                            <input class="inputs" id="edit_nombre" type="text" name="edit_nombre" placeholder="Nombre" required/>
                            <ion-icon name="duplicate-outline" class="icon"></ion-icon>
                        </div>

                        <div class="input-box">
                            <label for="edit_apellido"></label>
                            <input class="inputs" id="edit_apellido" type="text" name="edit_apellido" placeholder="Apellido" required/> 
                            <ion-icon name="duplicate-outline" class="icon"></ion-icon>
                        </div>

                        <div class="input-box">
                            <label for="edit_correo"></label>
                            <input class="inputs" id="edit_correo" type="email" name="edit_correo" placeholder="Correo" required/>
                            <ion-icon name="duplicate-outline" class="icon"></ion-icon>
                        </div>

                        <div class="input-box">
                            <label for="edit_password"></label>
                            <input class="inputs" id="edit_password" type="password" name="edit_password" placeholder="Password" required/>
                            <ion-icon name="duplicate-outline" class="icon"></ion-icon>
                        </div>
                        
                        <div class="btn-box">
                            <button type="submit" class="btn btn-add">Editar</a></button>
                            <a href='actualizar_datos.php?'><ion-icon name='create-outline'></ion-icon></a> </td>
                        </div>

                    </div>
                </form>

                <div class="button-box">
                    <button class="btn btn-1" id="btn"><a href="editarUsuario.php">Regresar</a></button>
                </div>
                
            </div>
        </div> 


        <!-- FORM PARA EDITAR UNICAMENTE STATUS -->
        <div class="form-container">
            <div class="form-col">
      
                <form class="form" action="actualizarStatus.php?id_usuario=<?php echo $id_usuario; ?>" method="POST">

                    <div class="form-title">
                        <span>Editar Status</span>
                    </div>

                    <div class="form-inputs">
                        <div class="input-box">
                            <label for="edit_cargo"></label>
                            <input class="inputs" id="edit_cargo" type="text" name="edit_cargo" placeholder="Establece el cargo" required/>
                            <ion-icon name="duplicate-outline" class="icon"></ion-icon>
                        </div>

                        
                        <div class="btn-box">
                            <button type="submit" class="btn btn-add">Editar Status</a></button>
                            <a href='actualizar_datos.php?'><ion-icon name='create-outline'></ion-icon></a> </td>
                        </div>
                    </div>
                </form>

                <div class="button-box">
                    <button class="btn btn-1" id="btn"><a href="editarUsuario.php">Regresar</a></button>
                </div>
                
            </div>
        </div> 


    </div> <!---div del container -->
    </div>

    <!-- ICONS -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <?php 
    // respuestas de confirmacion o no

    if (@$_GET['respuesta'] == 1) { ?>
    <h2 style="color: #0f0;">Datos del usuario editados correctamente</h2>

    <?php 
    }
    ?>

    <?php
    if (@$_GET['respuesta'] == 2) { ?>
    <h2 style="color: #f03;">Sistema en mantenimiento. Intente mas tarde</h2>

    <?php 
    }
    ?>

</body>
</html>
