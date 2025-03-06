<?php
    include "../conexion.php";

    $correo=$_POST['correo'];

    $contrasena_input=$_POST['password'];
    $contrasena_input_encriptada=md5($contrasena_input);

    session_start();
    $_SESSION['usuario']=$correo;

    $consulta="SELECT*FROM usuarios where correo_usuario='$correo' and contrasena_usuario='$contrasena_input_encriptada'";
    $resultado=mysqli_query($conex,$consulta);
    $filas=mysqli_fetch_array($resultado);

    if($filas['id_cargo']==1){ //administrador
        header("location:../pantallaAdmin/editarUsuario.php");

    }else
    if($filas['id_cargo']==2){ //cliente
    header("location:../pantallaCliente/cliente_waiting.php");
    }
    else{
        echo '
        <script>
            alert("Datos no encontrados. Verifique con tranquilidad.");
            window.location = "../logIn_register.php";
        </script>
        ';
    }

    mysqli_free_result($resultado);
    mysqli_close($conex);
?>