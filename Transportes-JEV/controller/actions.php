<?php 
include "conexion.php";

extract($_POST);

switch ($hidden) {
    
    /* REGISTRO DE USUARIOS */
    case 1:

    /* Verificación de datos ya registrados (correo) */
    $stmt = $conex->prepare("SELECT * FROM usuarios WHERE correo_usuario = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("location:../view/login/index.php?show=register&error=correoExistente");
        exit;
    
    } else {
        // Si no hay coincidencias, continuar con el registro
        //$password_hashed = hash('sha256', $password);
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conex->prepare("INSERT INTO usuarios (nombre_usuario, correo_usuario, password_us, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $correo, $password_hashed, $id_cargo);
        // Establecer valores
        $id_cargo = 2;

        if ($stmt->execute()) {
            header("location:../view/login/index.php?show=register&usuarioRegistrado=1");
            exit;

        } else {
            header("location:../view/login/index.php?show=register&errorRegistro=2");
        }

        $stmt->close();
        $conex->close();        
    }

    /* LOG IN DE USUARIOS */
    case 2:


        
}





?>