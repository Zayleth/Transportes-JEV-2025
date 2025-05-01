<?php
/* Archivo creado para transferir datos desde un Google Sheets a la tabla users_from_chatbot */
include "controller/conexion.php";
require 'vendor/autoload.php';

// Archivo de log
$logFile = 'error_log.txt';

try {
    // Configuración del Cliente API
    $client = new Google_Client();
    $client->setAuthConfig('config/credenciales.json');
    $client->setScopes(['https://www.googleapis.com/auth/spreadsheets.readonly']);

    // Conexión al servicio de Google Sheets
    $service = new Google_Service_Sheets($client);

    // Especificación de la hoja y rango de datos
    $spreadsheetId = '1DDmP3jt7Jl1Inze-1eNevBpP-ihHvILeYsQxAF3xcd0';
    $range = 'Hoja 1!A2:B'; 

    // Obtención de los datos
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    // Verificar si hay datos antes de procesar
    if (empty($values)) {
        throw new Exception("No se encontraron datos en la hoja de cálculo.");
    }

    // Procesar cada fila
    foreach ($values as $row) {
        $nombreUsuario = $row[0] ?? ''; 
        $correoUsuario = $row[1] ?? ''; 
    
        // Verificación de correo duplicado antes de insertar
        $correoDuplicado = "SELECT correo_newUsuario FROM users_from_chatbot WHERE correo_newUsuario = ?";
        $stmtCheck = $conex->prepare($correoDuplicado);
        $stmtCheck->bind_param("s", $correoUsuario);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            echo "Correo ya existe y fue omitido: " . $correoUsuario . "<br>";
            $stmtCheck->close();
            continue; // Evita la inserción y pasa a la siguiente fila
        }
    
        // Insertar usuario en la base de datos
        $stmtInsert = $conex->prepare("INSERT INTO users_from_chatbot (nombre_newUsuario, correo_newUsuario) VALUES (?, ?)");
        if (!$stmtInsert) {
            throw new Exception("Error al preparar la consulta SQL: " . $conex->error);
        }
    
        if (!$stmtInsert->bind_param("ss", $nombreUsuario, $correoUsuario)) {
            throw new Exception("Error al vincular parámetros: " . $stmtInsert->error);
        }
    
        if (!$stmtInsert->execute()) {
            throw new Exception("Error en la ejecución del SQL: " . $stmtInsert->error);
        }
    
        $stmtInsert->close();
    }

    // Cerrar conexión
    $conex->close();

    // Registrar éxito
    echo "Proceso completado. Datos insertados correctamente " . date('Y-m-d H:i:s');

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage() . "\n", 3, $logFile);
}
?>