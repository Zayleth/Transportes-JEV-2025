<?php
session_start();
if(isset($_SESSION['usuario'])) {

    include "../conexion.php";

    // Obtener datos del formulario
    $id_Nuevo = $_GET['id_usuario'];
    $edit_nombre = $_POST['edit_nombre'];
    $edit_apellido = $_POST['edit_apellido'];
    $edit_correo = $_POST['edit_correo'];
    $edit_password = $_POST['edit_password']; // Obtener la contraseña del formulario

    // Encriptar la contraseña
    $edit_password_encriptada = md5($edit_password); // contrasena encriptada
       
    $editar_caracteristicas = "UPDATE usuarios SET nombre_usuario = '$edit_nombre', apellido_usuario = '$edit_apellido', correo_usuario = '$edit_correo', 
                            contrasena_usuario = '$edit_password_encriptada' WHERE id_usuario = '$id_Nuevo'";

    // Ejecutar consulta
    $resultado = mysqli_query($conex, $editar_caracteristicas);

    // Manejar errores
    if ($resultado) {
        echo "<script language='JavaScript'>
                alert('Datos actualizados correctamente');
                window.location.href = 'editarUsuario.php?respuesta=1';
            </script>";
            //var_dump($resultado);

    } else {
            echo "<script language='JavaScript'>
                alert('Error al actualizar datos: " . $stmt->error . "'); // Mostrar mensaje de error específico
                window.location.href = 'editarUsuario.php?respuesta=2';
            </script>";
    }

        // Cerrar conexión
        mysqli_close($conex);

}
?>
