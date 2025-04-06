<?php 
include "conexion.php";

extract($_POST);
extract($_GET);

switch ($hidden) {
    
    // REGISTRO DE USUARIOS 
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
            header("location:../view/login/index.php?show=register&errorRegistro=3");
            exit;
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || !preg_match($regex_correo, $correo)) {
            header("location:../view/login/index.php?show=register&errorRegistro=3");
            exit;
        }
        if (!preg_match($regex_password, $password)) {
            header("location:../view/login/index.php?show=register&errorRegistro=3");
            exit;
        }

        // Verificar conexión
        if (!$conex) {
            header("location:../view/login/index.php?show=register&errorRegistro=2");
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
       

    // LOG IN DE USUARIOS 
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
        

    // CAMBIO DE CONTRASEÑA 
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

    // CALCULADORA DE FLETES - FUNCIONAMIENTO
    case 4: 
        session_start();
        // Consulta optimizada con filtro
        $query = "SELECT origen_viaje, destino_viaje, precio_viaje FROM viajes WHERE origen_viaje = ? AND destino_viaje = ?";
        $stmt = $conex->prepare($query); // Uso de consultas preparadas
        $stmt->bind_param("ss", $origen_viaje, $destino_viaje);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        
        if ($fila) {
            // Almacenar los datos en sesión
            $_SESSION['origen'] = $fila["origen_viaje"];
            $_SESSION['destino'] = $fila["destino_viaje"];
            $_SESSION['precio'] = $fila["precio_viaje"];
        
            // Redirigir sin exponer información en la URL
            header("Location: ../view/pantallaCliente/calculadoraFletes/calculadora.php");
            exit();

        } else {
           
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['origen_viaje']) && !empty($_POST['destino_viaje'])) {
                
                $origen = urlencode($_POST['origen_viaje']);
                $destino = urlencode($_POST['destino_viaje']);
                //$whatsapp_url = "https://wa.me/584143991619?text=Hola,%20solicito%20un%20flete%20desde%20" . $origen . "%20hacia%20" . $destino .".%20Quedo%20atento(a)%20a%20su%20respuesta";
                $whatsapp_url = "https://wa.me/584143991619?text=" . urlencode("Hola, solicito un flete desde $origen hacia $destino. Quedo atento(a) a su respuesta");

                // Redirigir al archivo calculadora.php con el enlace de WhatsApp como parámetro
                $redirect_url = "../view/pantallaCliente/calculadoraFletes/calculadora.php?data=1&whatsapp_url=" . urlencode($whatsapp_url);
                header("Location: $redirect_url");
                exit;
                
            } else {
                //echo "<p>Error: Datos del formulario incompletos.</p>";
                header("Location: ../view/pantallaCliente/calculadoraFletes/calculadora.php?data=2");
            }
            
            
            //header("Location: ../view/pantallaAdmin/calculadoraFletes/calculadora.php?data=1");
            //exit();
        }

    // CALCULADORA DE FLETES - AGREGAR NUEVO FLETE
    case 5:
        session_start();

        // Obtener y limpiar los datos enviados por el formulario
        $origen = trim($_POST['nuevoOrigen']);
        $destino = trim($_POST['nuevoDestino']);
        $precio = trim($_POST['nuevoPrecio']);
        
        // Expresiones regulares para validación
        $regex_origen = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
        $regex_destino = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
        $regex_precio = '/^\d+(\.\d{1,2})?$/';

        // Validación de campos vacíos
        if (empty($origen) || empty($destino) || !$regex_precio) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=1"); // Campos vacíos
            exit;
        }

        // Validar formato de los datos
        if (!preg_match($regex_nombre, $nombre) || !preg_match($regex_destino, $destino)) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=1");
            exit;
        }
        
        // Verificar flete existente
        $stmt = $conex->prepare("SELECT COUNT(*) FROM viajes WHERE $origen = ? AND $destino = ?");
        $stmt->bind_param("ss", $origen, $destino);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            header("../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?fleteExistente=0");
            exit;
        }

        $query = "INSERT INTO viajes (origen_viaje, destino_viaje, precio_viaje) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conex, $query);
        
        mysqli_stmt_bind_param($stmt, "ssd", $nuevoOrigen, $nuevoDestino, $nuevoPrecio); // ssd = string, string, double
        $resultado = mysqli_stmt_execute($stmt);
        
        // Verificar conexión
        if (!$conex) {
            header("../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=2");
            exit;
        }

        // Si pasa los filtros:
        if ($resultado) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?success=3");
            exit();
        } else {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=2");
            exit();
        }
        
        mysqli_stmt_close($stmt);
        
}       


?>

