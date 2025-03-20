<?php
    include "../conexion.php";
    if (isset($_POST['modelo_camion'])) {
        $modeloC = mysqli_real_escape_string($conex, $_POST['modelo_camion']);
    
        $query = "SELECT capacidad_camion FROM camiones WHERE modelo_camion = '$modeloC'";
        $resultado = mysqli_query($conex, $query);
    
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo '<option value="' . htmlspecialchars($fila['capacidad_camion']) . '">' . htmlspecialchars($fila['capacidad_camion']) . ' kg</option>';
            }
        } else {
            echo '<option value="" disabled>No se encontró la capacidad del camión.</option>';
        }
    }
?>
