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
        $query = "SELECT modelo_camion, tipo_camion, capacidad_camion FROM camions WHERE modelo_camion = ? AND tipo_camion = ?";
        $stmt = $conex->prepare($query); // Uso de consultas preparadas
        $stmt->bind_param("ss", $modelo_camion, $tipo_camion);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        
        if ($fila) {
            // Almacenar los datos en sesión
            $_SESSION['modelo'] = $fila["modelo_camion"];
            $_SESSION['tipo'] = $fila["tipo_camion"];
            $_SESSION['capacidad'] = $fila["capacidad_camion"];
        
            // Redirigir sin exponer información en la URL
            header("Location: ../view/pantallaCliente/calculadoraFletes/calculadora.php");
            exit();

        } else {
           
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['modelo_camion']) && !empty($_POST['tipo_camion'])) {
                
                $modelo = urlencode($_POST['modelo_camion']);
                $tipo = urlencode($_POST['tipo_camion']);
                //$whatsapp_url = "https://wa.me/584143991619?text=Hola,%20solicito%20un%20flete%20desde%20" . $modelo . "%20hacia%20" . $tipo .".%20Quedo%20atento(a)%20a%20su%20respuesta";
                $whatsapp_url = "https://wa.me/584143991619?text=" . urlencode("Hola, solicito un flete desde $modelo hacia $tipo. Quedo atento(a) a su respuesta");

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

    // FUNCION ADMIN EDITAR - CALCULADORA DE FLETES - AGREGAR NUEVO FLETE
    case 5:

        session_start();

        // Obtener y limpiar los datos enviados por el formulario
        $origen = trim($_POST['origen']);
        $destino = trim($_POST['destino']);
        $precio = trim($_POST['capacidad']);

        // Expresiones regulares para validación
        $regex_origen = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
        $regex_destino = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
        $regex_precio = '/^\d+$/'; // numero entero

        // Validación de campos vacíos y formato
        if (empty($origen) || empty($destino) || !preg_match($regex_precio, $precio)) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=1"); // Campos vacíos o formato inválido
            exit;
        }

        if (!preg_match($regex_origen, $origen) || !preg_match($regex_destino, $destino)) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=1"); // Formato inválido
            exit;
        }

        // Verificar conexión
        if (!$conex) {
            //error_log("Error en la conexión a la base de datos.");
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=2");
            exit;
        }

        // Verificar flete existente
        $queryCheck = "SELECT COUNT(*) FROM viajes WHERE origen_viaje = ? AND destino_viaje = ?";
        $stmt = $conex->prepare($queryCheck);

        if (!$stmt) {
            //error_log("Error en la preparación de la consulta: " . $conex->error);
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?error=stmt_failed");
            exit;
        }

        $stmt->bind_param("ss", $origen, $destino);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?fleteExistente=0");
            exit;
        }

        // Insertar nuevo flete
        $queryInsert = "INSERT INTO viajes (origen_viaje, destino_viaje, precio_viaje) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conex, $queryInsert);

        if (!$stmt) {
            //error_log("Error al preparar la consulta de inserción: " . mysqli_error($conex));
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?error=stmt_failed");
            exit;
        }

        mysqli_stmt_bind_param($stmt, "ssd", $origen, $destino, $precio); // ssd: string, string, double
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            error_log("Error al ejecutar la consulta de inserción: " . mysqli_error($conex));
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=2");
            exit;
        }

        // Finalizar
        mysqli_stmt_close($stmt);
        header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?success=3");
        exit;
        

    // FUNCION ADMIN EDITAR - CALCULADORA DE FLETES - AGREGAR NUEVO CAMIÓN
    case 6:
        
        session_start();
        // Obtener y limpiar los datos enviados por el formulario
        $modelo = trim($_POST['origen']);
        $tipo = trim($_POST['destino']);
        $capacidad = trim($_POST['capacidad']);

        // Expresiones regulares para validación
        $regex_modelo = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
        $regex_tipo = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
        $regex_capacidad = '/^\d+$/';

        // Validación de campos vacíos y formatos
        if (empty($modelo) || empty($tipo) || !preg_match($regex_capacidad, $capacidad)) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoCamion.php?errorF=1"); // Campos vacíos o formato inválido
            exit;
        }

        if (!preg_match($regex_modelo, $modelo) || !preg_match($regex_tipo, $tipo)) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoCamion.php?errorF=1"); // Formato inválido
            exit;
        }

        // Verificar conexión
        if (!$conex) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoCamion.php?errorF=2");
            exit;
        }

        // Preparar consulta
        $query = "INSERT INTO camiones (modelo_camion, tipo_camion, capacidad_camion) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conex, $query);

        // Asignar valores y ejecutar
        mysqli_stmt_bind_param($stmt, "ssd", $modelo, $tipo, $capacidad); // ssd = string, string, double
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoCamion.php?errorF=2");
            exit;
        }

        // Finalizar y cerrar
        mysqli_stmt_close($stmt);
        header("location:../view/pantallaAdmin/calculadoraEdit/nuevoCamion.php?success=3");
        exit;
        
}       


?>

