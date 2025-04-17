<?php 
include "conexion.php";

extract($_POST);
extract($_GET);

switch ($hidden) {
    
    // REGISTRO DE USUARIOS 
    case 1:

        // Obtener y limpiar los datos enviados por el formulario
        $nombre = ucwords(strtolower(trim($_POST['nombre']))); // Convierte la str en minuscula y coloca las primeras letras mayúsculas
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
            exit;
        } else {
            header("location:../view/login/index.php?show=register&errorRegistro=2"); // Error de registro
            exit;
        }
        exit;
        break;

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
                header("location:../view/pantallaAdmin/calculadoraFletesAdmin/calculadora.php");
                exit;
            } else if ($fila['id_cargo'] == 2) {
                header("location:../view/pantallaCliente/calculadoraFletes/calculadora.php");
                exit;
            }
            exit;

        } else {
            // Redirigir con un mensaje genérico de error | Correo o contraseña erróneos
            header("location:../view/login/index.php?errorDatos=1");
            exit;
        }
        
        $stmt->close();
        mysqli_close($conex);
        break;

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
                exit;
            } else {
                header("location:../view/login/assets/olvido_pass.php?fallo=1"); // Error en la actualización
                exit;
            }
        } else {
            header("location:../view/login/assets/olvido_pass.php?error=2"); // Correo no encontrado
            exit;
        }

        // Cerrar conexiones
        $stmt->close();
        $conex->close();
        break;

    // FIX: CALCULADORA DE FLETES - FUNCIONAMIENTO
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
            header("Location: ../view/pantallaCliente/calculadoraFletes/calculadora.php?flete=1");
            exit();

        } else {
           
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['origen_viaje']) && !empty($_POST['destino_viaje'])) {
                
                $origen = urlencode($_POST['origen_viaje']);
                $destino = urlencode($_POST['destino_viaje']);
                //$whatsapp_url = "https://wa.me/584143991619?text=Hola,%20solicito%20un%20flete%20desde%20" . $modelo . "%20hacia%20" . $tipo .".%20Quedo%20atento(a)%20a%20su%20respuesta";
                $whatsapp_url = "https://wa.me/584143991619?text=" . urlencode("Hola, solicito un flete desde $origen hacia $destino. Quedo atento(a) a su respuesta");

                // Redirigir al archivo calculadora.php con el enlace de WhatsApp como parámetro
                $redirect_url = "../view/pantallaCliente/calculadoraFletes/calculadora.php?data=1&whatsapp_url=" . urlencode($whatsapp_url);
                header("Location: $redirect_url");
                exit;
                
            } else {
                //echo "<p>Error: Datos del formulario incompletos.</p>";
                header("Location: ../view/pantallaCliente/calculadoraFletes/calculadora.php?data=2");
                exit;
            }
            
            
            //header("Location: ../view/pantallaAdmin/calculadoraFletes/calculadora.php?data=1");
            //exit();
        }
        break;

    // FUNCION ADMIN EDITAR - CALCULADORA DE FLETES - AGREGAR NUEVO FLETE
    case 5:

        session_start();

        // Obtener y limpiar los datos enviados por el formulario
        $origen = ucwords(strtolower(trim($_POST['origen'])));
        $destino = ucwords(strtolower(trim($_POST['destino'])));
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
            // error_log("Error al ejecutar la consulta de inserción: " . mysqli_error($conex));
            header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?errorF=2");
            exit;
        }

        // Finalizar
        mysqli_stmt_close($stmt);
        header("location:../view/pantallaAdmin/calculadoraEdit/nuevoFlete.php?success=3");
        exit;
        break;
        

    // FUNCION ADMIN EDITAR - CALCULADORA DE FLETES - AGREGAR NUEVO CAMIÓN
    case 6:
        
        session_start();
        // Obtener y limpiar los datos enviados por el formulario
        $modelo = ucwords(strtolower(trim($_POST['origen'])));
        $tipo = ucwords(strtolower(trim($_POST['destino'])));
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

        break;

    // FUNCION ADMIN CAMIONES REGISTRADOS - NAVBAR OPTIONS - EDITAR CAMIÓN
    case 7:
        // Obtener el ID desde la URL con seguridad
        $id_camion_mod = isset($_POST['id_camion']) ? intval($_POST['id_camion']) : 0;            
        $nuevo_status = isset($_POST['nuevo_status']) && trim($_POST['nuevo_status']) !== "" ? trim($_POST['nuevo_status']) : "Disponible";
    
        // Asegurarse de que el ID es válido antes de ejecutar la consulta
        if ($id_camion_mod > 0) {
            // Consulta preparada
            $query = "UPDATE camiones SET modelo_camion = ?, tipo_camion = ?, capacidad_camion = ?, status_camion = ? WHERE id_camion = ?";
            
            $stmt = $conex->prepare($query);
            $stmt->bind_param("ssisi", ucwords(strtolower(trim($origen))), ucwords(strtolower(trim($destino))), $capacidad, $nuevo_status, $id_camion_mod);
            $stmt->execute();
            
            // Redireccionar según el resultado
            $redirectUrl = ($stmt->affected_rows > 0) 
                ? "../view/pantallaAdmin/navbarOptions/camionesRegistrados.php" 
                : "../view/pantallaAdmin/navbarOptions/editarC-F-U/editarCamion.php?errorF=1";
    
            $stmt->close();
        } else {
            $redirectUrl = "../view/pantallaAdmin/navbarOptions/editarC-F-U/editarCamion.php?errorF=2";
        }
    
        $conex->close();
        header("location: $redirectUrl");
        exit;
        break;
    
    
    // FUNCION ADMIN CAMIONES REGISTRADOS - NAVBAR OPTIONS - ELIMINAR CAMIÓN
    case 8:
        $id_camionEliminar = $_POST['id_camionEliminar'];

        $query = "DELETE FROM camiones WHERE id_camion = ?";
        $stmt = $conex->prepare($query);
        $stmt->bind_param("i", $id_camionEliminar);

        if ($stmt->execute()) {
            echo "<script>window.location.href='../view/pantallaAdmin/navbarOptions/camionesRegistrados.php';</script>"; // Redirige después
        } else {
            echo "<script>alert('Error al eliminar el elemento')</script>";
        }

        $stmt->close();
        break;

    // FUNCION ADMIN FLETES EXISTENTES - NAVBAR OPTIONS - EDITAR FLETE
    case 9:
        // Obtener el ID desde la URL con seguridad
        $id_flete_mod = isset($_POST['id_flete']) ? intval($_POST['id_flete']) : 0;            

        // Asegurarse de que el ID es válido antes de ejecutar la consulta
        if ($id_flete_mod > 0) {
            // Consulta preparada
            $query = "UPDATE viajes SET origen_viaje = ?, destino_viaje = ?, precio_viaje = ? WHERE id_viaje = ?";
            
            $stmt = $conex->prepare($query);
            $stmt->bind_param("ssii", ucwords(strtolower(trim($origen))), ucwords(strtolower(trim($destino))), $capacidad, $id_flete_mod); /* NOTA: el nombre de las variables es para optimizar el filtro de datos JS */
            $stmt->execute();
        
            // Verificar si la actualización fue exitosa
            if ($stmt->affected_rows > 0) {
                header("location:../view/pantallaAdmin/navbarOptions/fletesExistentes.php");
                exit;
            } else {
                header("location:../view/pantallaAdmin/navbarOptions/editarC-F-U/editarFlete.php?errorF=1"); 
                exit;
            }
        } else {  
            header("location:../view/pantallaAdmin/navbarOptions/editarC-F-U/editarFlete.php?errorF=2"); 
            exit;      
        }
        
        $stmt->close();        
        $conex->close();
        exit;
        break;

    // FUNCION ADMIN FLETES EXISTENTES - NAVBAR OPTIONS - ELIMINAR FLETE
    case 10:
        $id_fleteEliminar = $_POST['id_fleteEliminar'];

        $queryEliminarFlete = "DELETE FROM viajes WHERE id_viaje = ?";
        $stmt = $conex->prepare($queryEliminarFlete);
        $stmt->bind_param("i", $id_fleteEliminar);

        if ($stmt->execute()) {
            echo "<script>window.location.href='../view/pantallaAdmin/navbarOptions/fletesExistentes.php';</script>"; // Redirige después
        } else {
            echo "<script>alert('Error al eliminar el flete')</script>";
        }

        $stmt->close();
        break;

    // FUNCION ADMIN USUARIOS REGISTRADOS - NAVBAR OPTIONS - EDITAR USUARIO
    case 11:
        $verificar_cargo = $conex->prepare("SELECT id FROM cargos WHERE id = ?");
        $verificar_cargo->bind_param("i", $nuevo_cargo);
        $verificar_cargo->execute();
        $verificar_cargo->store_result();

        if ($verificar_cargo->num_rows === 0) {
            header("location:../view/pantallaAdmin/navbarOptions/editarC-F-U/editarUsuario.php?errorF=1");
            // echo "Error: Asegurate de rellenar correctamente los campos.";
            // echo "Error: El cargo seleccionado no es válido.";
            exit;
        }

        $id_usuario_mod = isset($_POST['id_usuario']) ? intval($_POST['id_usuario']) : 0;            

        if ($id_usuario_mod > 0) {
            // Consulta preparada
            $query = $query = "UPDATE usuarios SET nombre_usuario = ?, id_cargo = ? WHERE id_usuario = ?";
            $stmt = $conex->prepare($query);
            $stmt->bind_param("sii", ucwords(strtolower(trim($nuevo_nombre_user))), $nuevo_cargo, $id_usuario_mod);
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                header("location:../view/pantallaAdmin/navbarOptions/usuariosRegistrados.php");
                exit;
            } else {
                header("location:../view/pantallaAdmin/navbarOptions/editarC-F-U/editarUsuario.php?errorF=1");
                exit;
            }

        } else {
            header("location:../view/pantallaAdmin/navbarOptions/editarC-F-U/editarUsuario.php?errorF=2");
            exit;
        }
        
        $conex->close();
        exit;
        break;

    // FUNCION ADMIN USUARIOS REGISTRADOS - NAVBAR OPTIONS - ELIMINAR USUARIO
    case 12:
        $id_usuarioEliminar = $_POST['id_usuarioEliminar'];

        $queryEliminarUsuario = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $conex->prepare($queryEliminarUsuario);
        $stmt->bind_param("i", $id_usuarioEliminar);

        if ($stmt->execute()) {
            echo "<script>window.location.href='../view/pantallaAdmin/navbarOptions/usuariosRegistrados.php';</script>"; // Redirige después
        } else {
            echo "<script>alert('Error al eliminar el usuario')</script>";
        }

        $stmt->close();
        break;

}       

?>

