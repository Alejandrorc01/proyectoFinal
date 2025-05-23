<?php
session_start(); // Inicia sesión para permitir el uso de $_SESSION
require_once "includes/db.php"; // Incluye el archivo de conexión a la base de datos

// Solo se procesa si el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoge los datos del formulario
    $usuario = trim($_POST["usuario"] ?? ''); // Elimina espacios en blanco
    $password = $_POST["password"] ?? ''; // Contraseña ingresada

    // Si falta alguno de los campos, redirige al login con mensaje de error
    if (!$usuario || !$password) {
        header("Location: login.php?error=" . urlencode("Por favor completa todos los campos."));
        exit;
    }

    // Busca al usuario en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $stmt->execute(['usuario' => $usuario]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si se encontró el usuario y si la contraseña es correcta
    if ($resultado && password_verify($password, $resultado["password"])) {
        $_SESSION["usuario"] = $resultado["usuario"]; // Guarda el usuario en sesión
        header("Location: index.php?login=1"); // Redirige al inicio con login exitoso
        exit;
    } else {
        // Si los datos no coinciden, vuelve al login con mensaje de error
        header("Location: login.php?error=" . urlencode("Usuario o contraseña incorrectos."));
        exit;
    }
} else {
    // Si se intenta acceder sin enviar formulario, redirige al login
    header("Location: login.php");
    exit;
}
