<?php
    include "../conexion.php";
    $query = "SELECT modelo_camion FROM camiones WHERE status_camion = 'Disponible'"; // Consulta SQL
    $resultado = mysqli_query($conex, $query); // Ejecutar la consulta correctamente

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conex)); // Manejo de errores
    }
?>
