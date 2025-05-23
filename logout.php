<?php
session_start(); // Inicia la sesión para poder acceder a los datos guardados

session_unset();    // Elimina todas las variables de sesión
session_destroy();  // Destruye completamente la sesión actual

// Redirige al usuario a la página principal
header("Location: index.php");
exit; // Asegura que no se siga ejecutando código después de la redirección
