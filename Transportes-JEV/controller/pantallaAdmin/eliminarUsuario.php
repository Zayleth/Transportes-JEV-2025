<?php
session_start();
if(isset($_SESSION['usuario'])) {

include "../conexion.php";

    // al parecer solo funciona con metodo get
    $id_usuario = $_GET['id_usuario'];

    // eliminar datos de la tabla usuarios where idUsuario
    $deleteUsuario = "DELETE FROM usuarios WHERE id_usuario = '$id_usuario'";
    $resultado = mysqli_query($conex, $deleteUsuario);


    if ($resultado) {
        // AGREGAR EL NOMBRE DEL USUARIO Q SE ELIMINO
        echo "<script language='JavaScript'>
            alert('Datos del usuario eliminados correctamente');
            window.location.href = 'editarUsuario.php';
        </script>";
    } else {
        echo "<script language='JavaScript'>
            alert('Datos del usuario no eliminados');
            window.location.href = 'editarUsuario.php';
        </script>";
    }

} else { header("location:logIn_register.php");}
?>
