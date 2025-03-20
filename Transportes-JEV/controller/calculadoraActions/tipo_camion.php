<?php 
    include "../conexion.php";
    // Verificar si se recibió el modelo de camión
    if (isset($_POST['modelo_camion'])) {
        $modelo = mysqli_real_escape_string($conex, $_POST['modelo_camion']);
    
        // Consulta para obtener el tipo de camión
        $query = "SELECT tipo_camion FROM camiones WHERE modelo_camion = '$modelo'";
        $resultado = mysqli_query($conex, $query);
    
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            //echo '<option value="tipo" disabled>Tipo de Camión</option>';
            echo '<option value="' . htmlspecialchars($fila['tipo_camion']) .'">' . htmlspecialchars($fila['tipo_camion']) . '</option>';
        } else {
            echo '<option value="" disabled>No se encontró el tipo de camión.</option>';
        }
    } else {
        echo '<option value="" disabled>No se proporcionó un modelo de camión.</option>';
    }
?>

