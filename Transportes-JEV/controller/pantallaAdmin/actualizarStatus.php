<?php
session_start();
if(isset($_SESSION['usuario'])) {

    include "../conexion.php";

    $id_usuario = $_GET['id_usuario'];
    // Obtener datos del formulario
    $edit_cargo = $_POST['edit_cargo']; 

    ///////////////////
    // Verificar si el nuevo id_cargo existe en la tabla roles
    $sql_verificar_cargo = "SELECT id FROM cargo WHERE id = $edit_cargo";
    $resultado_verificar = mysqli_query($conex, $sql_verificar_cargo);

    if ($resultado_verificar->num_rows > 0) {
        // El nuevo id_cargo existe, proceder a actualizar la tabla usuarios
        $editar_caracteristicas = "UPDATE usuarios SET id_cargo = '$edit_cargo' WHERE id_usuario = '$id_usuario'";


        // Ejecutar consulta
        $resultado = mysqli_query($conex, $editar_caracteristicas);

        // Manejar errores
        if ($resultado) {
            echo "<script language='JavaScript'>
                alert('Cargo actualizado correctamente');
                window.location.href = 'editarUsuario.php?respuesta=1';
            </script>";
            //var_dump($resultado);

        } else {
            echo "<script language='JavaScript'>
                alert('Error al actualizar cargo: " . $stmt->error . "'); // Mostrar mensaje de error específico
                window.location.href = 'editarUsuario.php?respuesta=2';
            </script>";
        }

        // Cerrar conexión
        mysqli_close($conex);

    } else {
        echo "<script language='JavaScript'>
            alert('El numero especificado no coincide con los cargos');
            window.location.href = '../logIn_register.php';
        </script>";
    }


}


?>