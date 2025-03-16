<?php 
include "conexion.php";

extract($_POST);

switch ($hidden) {
    
    /* REGISTRO DE USUARIOS */
    case 1:

        // Obtener y limpiar los datos enviados por el formulario
        $nombre = trim($_POST['nombre']);
        $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);
        
        // Expresiones regulares para validación
        $regex_nombre = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
        $regex_correo = '/^[a-zA-Z0-9_.+-]+@(gmail\.com|hotmail\.com|outlook\.com|[a-zA-Z0-9-]+\.(org|com|net))$/';
        $regex_password = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,50}$/';

        // Validación de campos vacíos
        if (empty($nombre) || empty($correo) || empty($password)) {
            header("location:../view/login/index.php?show=register&errorRegistro=3"); // Campos vacíos
            exit;
        }

        // Validar formato de los datos
        if (!preg_match($regex_nombre, $nombre)) {
            header("location:../view/login/index.php?show=register&errorRegistro=4");
            exit;
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match($regex_correo, $correo)) {
            header("location:../view/login/index.php?show=register&errorRegistro=5");
            exit;
        }
        if (!preg_match($regex_password, $password)) {
            header("location:../view/login/index.php?show=register&errorRegistro=6");
            exit;
        }

        // Verificar conexión
        if (!$conex) {
            header("location:../view/login/index.php?show=register&errorRegistro=7");
            exit;
        }

        // Verificar correo existente
        $stmt = $conex->prepare("SELECT COUNT(*) FROM usuarios WHERE correo_usuario = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            header("location:../view/login/index.php?show=register&correoExistente=1");
            exit;
        }
        

        // Registro de usuario
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $id_cargo = 2; // Cargo predeterminado
        $stmt = $conex->prepare("INSERT INTO usuarios (nombre_usuario, correo_usuario, password_us, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $correo, $password_hashed, $id_cargo);

        if ($stmt->execute()) {
            header("location:../view/login/index.php?show=register&usuarioRegistrado=1"); // Usuario Registrado
        } else {
            header("location:../view/login/index.php?show=register&errorRegistro=2"); // Error de registro
        }
        exit;
       

    /* LOG IN DE USUARIOS */
    case 2:

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conex->prepare("SELECT * FROM usuarios WHERE correo_usuario = ?");
        $stmt->bind_param("s", $correoLogIn);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        
        if ($fila && password_verify($passwordLogIn, $fila['password_us'])) {
            session_start();
            session_regenerate_id(true); // Regenerar ID de sesión
            $_SESSION['id_cargo'] = $fila['id_cargo'];
            $_SESSION['usuario'] = $fila['nombre_usuario'];
            $_SESSION['correo'] = $fila['correo_usuario'];
        
            // Redirigir según el rol
            if ($fila['id_cargo'] == 1) {
                header("location:../view/pantallaAdmin/calculadoraFletes/calculadora.html");
            } else if ($fila['id_cargo'] == 2) {
                header("location:../view/pantallaCliente/prueba.php");
            }
            exit;
        } else {
            // Redirigir con un mensaje genérico de error
            header("location:../view/login/index.php?errorDatos=1");
            exit;
        }
        
        $stmt->close();
        mysqli_close($conex);
        

    /* CAMBIO DE CONTRASEÑA */
    case 3:

        // Verificar si el correo existe
        $stmt = $conex->prepare("SELECT 1 FROM usuarios WHERE correo_usuario = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Hashear la nueva contraseña
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Actualizar la contraseña
            $stmt = $conex->prepare("UPDATE usuarios SET password_us = ? WHERE correo_usuario = ?");
            $stmt->bind_param("ss", $password_hashed, $correo);
            $stmt->execute();

            // Verificar si se actualizó correctamente
            if ($stmt->affected_rows > 0) {
                header("location:../view/login/assets/olvido_pass.php?success=1"); // Contraseña actualizada
            } else {
                header("location:../view/login/assets/olvido_pass.php?fallo=1"); // Error en la actualización
            }
        } else {
            header("location:../view/login/assets/olvido_pass.php?error=2"); // Correo no encontrado
        }

        // Cerrar conexiones
        $stmt->close();
        $conex->close();


}


?>
