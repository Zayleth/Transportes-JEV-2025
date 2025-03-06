<?php 
    include "../conexion.php";

    /* Registro de los usuarios en la base de datos */
    /* Extraemos las variables */

    $nombre_usuario = $_POST['nombre'];
    $apellido_usuario = $_POST['apellido'];
    $correo_usuario = $_POST['correo'];
    $contrasena_usuario = $_POST['password']; // contrasena 
    $contrasena_encriptada = md5($contrasena_usuario); // contrasena encriptada

    $registrar_usuario = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, correo_usuario, contrasena_usuario, id_cargo) VALUES ('$nombre_usuario', '$apellido_usuario', '$correo_usuario', '$contrasena_encriptada', '2')";
    
    /* Verificar el correo no se repitan en la base de datos */
    $query = "SELECT * FROM usuarios WHERE correo_usuario = '$correo_usuario'";
    $verificar_correo = mysqli_query($conex, $query);

    if(mysqli_num_rows($verificar_correo) > 0) {
        echo '
        <script>
            alert("Correo ya registrado. Intente con un correo diferente.");
            window.location = "logIn_register.php";
        </script>
        
        ';
        exit();
    }


    /* Registro de usuario */
    $resultado = mysqli_query($conex, $registrar_usuario);

    if ($resultado) {
        //echo "Datos insertados correctamente";
        echo '
        <script>
            alert("Usuario registrado exitosamente!");
            window.location = "../logIn_register.php";
        </script>
        ';
    } else {
        echo '
        <script>
            alert("Usuario no registrado");
            window.location = "../logIn_register.php";
        </script>
        '; 
    }
    
    mysqli_close($conex);
?>