<?php
/* Archivo creado para transferir datos desde un Google Sheets a la tabla users_from_chatbot */
include "controller/conexion.php";
require 'vendor/autoload.php';

// Archivo de log
$logFile = 'error_log.txt';

try {
    // Configuración del Cliente API
    $client = new Google_Client();
    $client->setAuthConfig('credenciales.json');
    $client->setScopes(['https://www.googleapis.com/auth/spreadsheets.readonly']);

    // Conexión al servicio de Google Sheets
    $service = new Google_Service_Sheets($client);

    // Especificación de la hoja y rango de datos
    $spreadsheetId = '1DDmP3jt7Jl1Inze-1eNevBpP-ihHvILeYsQxAF3xcd0';
    $range = 'Hoja 1!A:B'; // Se accede a todas las filas en las columnas A y B de la hoja "Hoja 1 del Google Sheet".

    // Obtención de los datos
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    // Verificar si hay datos antes de procesar
    if (empty($values)) {
        throw new Exception("No se encontraron datos en la hoja de cálculo.");
    }

    // Procesar cada fila
    foreach ($values as $row) {
        $nombreUsuario = $row[0] ?? ''; // Prevención de índices no definidos
        $correoUsuario = $row[1] ?? '';

        // Verificacion de correo duplicado
        $correoDuplicado = "SELECT correo_newUsuario FROM users_from_chatbot WHERE correo_newUsuario = ?";
        $stmt = $conex->prepare($correoDuplicado);
        $stmt->bind_param("s", $correoUsuario);
        $stmt->execute();
        $stmt->store_result();
        
        // Si existe al menos un resultado, no insertamos
        if ($stmt->num_rows > 0) {
            $stmt->close();
            continue;
            // exit("Este correo ya existe en la base de datos.");
        }
        $stmt->close();

        // Preparar consulta de inserción
        $stmtInsert = $conex->prepare("INSERT INTO users_from_chatbot (nombre_newUsuario, correo_newUsuario) VALUES (?, ?)");
        if (!$stmtInsert) {
            throw new Exception("Error al preparar la consulta SQL: " . $mysqli->error);
        }

        if (!$stmtInsert->bind_param("ss", $nombreUsuario, $correoUsuario)) {
            throw new Exception("Error al vincular parámetros: " . $stmtInsert->error);
        }

        if (!$stmtInsert->execute()) {
            throw new Exception("Error en la ejecución del SQL: " . $stmtInsert->error);
        }

        $stmtInsert->close();

    }

    // Cerrar conexión solo si todo salió bien
    $conex->close();

    // Registrar éxito
    echo "Proceso completado. Datos insertados correctamente " . date('d-m-Y H:i:s');

} catch (Exception $e) {
    // Registrar cualquier error en el archivo de log
    error_log("Error: " . $e->getMessage() . "\n", 3, $logFile);
}
?>
