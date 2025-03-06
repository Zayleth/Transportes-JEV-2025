<?php
// mysqli_connect -> forma de conectarse a la base de datos
// creado para establecer la conexion a la base de datos
$conex = mysqli_connect("localhost", "root", "", "autenticacion_usuario") or die("Could not connect to database. Try later");
?>


<?php
/*
if (!$conex) {
    echo "Error al conectar a la base de datos: " . mysqli_error($conex);
    exit;
} else {
    echo "Conectado a la base de datos con éxito!";
}
*/
?>
