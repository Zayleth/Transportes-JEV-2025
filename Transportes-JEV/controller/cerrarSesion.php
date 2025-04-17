<?php
session_start();

// Verifica si hay  sesión activa
if (isset($_SESSION['usuario'])) {
    session_unset(); 
    session_destroy(); 
    header("location: ../index.html");
    exit;
} else {
    header("location: ../index.html"); 
    // echo "No existe la sesión";
    exit;
}
?>
