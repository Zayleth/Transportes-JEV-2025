<?php
session_start();
if(isset($_SESSION['usuario'])) {
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/View/editarUsuarios.css">
        <title>Editar Usuarios</title>

            <script>
                function confirmarEliminarUsuario() {
                    return confirm("¿Estas seguro que deseas eliminar los datos del usuario?");
                }
            </script>

    </head>

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

<body>
    <div class="field-container">

    <!--.php -> archivo creado para -->
    <div class="field-title">
        <h1>Editar Usuarios</h1>
    </div>

    <!--CUADRO CON LAS CARACTERISTICAS DE TODOS LOS USUARIOS-->

    <?php
    $caracteristicasGenerales = "SELECT * FROM usuarios";
    $resultado = mysqli_query($conex, $caracteristicasGenerales);

    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {
            echo "<table>";
                echo "<thead>";
                    echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Nombre</th>";
                        echo "<th>Apellido</th>";
                        echo "<th>Correo</th>";
                        echo "<th>Editar</th>";
                        echo "<th>Eliminar</th>";
                    echo "</tr>";
                echo "</thead>";
            
            echo "<tbody>";

            // Iterar sobre todos los resultados
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                    echo "<td>" . $fila['id_usuario'] . "</td>";
                    echo "<td>" . $fila['nombre_usuario'] . "</td>"; 
                    echo "<td>" . $fila['apellido_usuario'] . "</td>";
                    echo "<td>" . $fila['correo_usuario'] . "</td>";
                    echo "<td> <a class='icon' href='editarUnUsuario.php?id_usuario=".$fila['id_usuario']."'onclick'><ion-icon name='create-outline'></ion-icon></a> </td>";
                    echo "<td> <a class='icon' href='eliminarUsuario.php?id_usuario=".$fila['id_usuario']."'onclick='return confirmarEliminarUsuario()'><ion-icon name='trash-outline'></ion-icon></a></td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        
        } else {
            echo "No se encontraron resultados.";
        }

    } else {
        // AGREGAR PAGINA DE SISTEMA EN MANTENIMIENTO
        //header("location: registro.php");
        echo "Error al ejecutar la consulta: " . mysqli_error($conex);
    }
    ?>


        <div class="button-box">
            <input type="hidden">
            <a href="cerrarSesion.php"><button class="btn btn-1" id="btn">Cerrar Sesion</button></a>
        </div>

    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> 
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

<?php
    } else { header("location:logIn_register.php");}
?>

