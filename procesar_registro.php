<?php
session_start(); // Inicia la sesión
require_once "includes/db.php"; // Incluye el archivo de conexión a la base de datos con $pdo

// Solo procesa si se ha enviado el formulario por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoge y limpia los campos del formulario
    $usuario = trim($_POST["usuario"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $telefono = trim($_POST["telefono"] ?? '');
    $direccion = trim($_POST["direccion"] ?? '');
    $password = $_POST["password"] ?? '';
    $confirmar = $_POST["confirmar_password"] ?? '';

    // Verifica que todos los campos estén completos
    if (!$usuario || !$email || !$telefono || !$direccion || !$password || !$confirmar) {
        die("Por favor completa todos los campos.");
    }

    // Valida el formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("El correo no es válido.");
    }

    // Valida el formato del teléfono (debe tener 9 dígitos)
    if (!preg_match('/^[0-9]{9}$/', $telefono)) {
        die("El teléfono debe tener 9 dígitos.");
    }

    // Verifica que las contraseñas coincidan
    if ($password !== $confirmar) {
        die("Las contraseñas no coinciden.");
    }

    // Comprueba si ya existe el usuario o el email
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email");
    $stmt->execute(['usuario' => $usuario, 'email' => $email]);

    if ($stmt->fetch()) {
        die("El usuario o el email ya están registrados.");
    }

    // Cifra la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Inserta el nuevo usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, email, telefono, direccion, password) VALUES (:usuario, :email, :telefono, :direccion, :password)");
    $resultado = $stmt->execute([
        'usuario' => $usuario,
        'email' => $email,
        'telefono' => $telefono,
        'direccion' => $direccion,
        'password' => $passwordHash
    ]);

    // Si se registró correctamente, redirige al login
    if ($resultado) {
        header("Location: login.php?registro=exitoso");
        exit;
    } else {
        die("Error al registrar el usuario.");
    }
} else {
    // Si se accede directamente sin enviar el formulario, redirige al registro
    header("Location: registro.php");
    exit;
}
