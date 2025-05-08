<?php
session_start();

// Usuario y contraseña (puedes cambiarlos)
$usuario_valido = "admin";
$contrasena_valida = "1234";
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if ($usuario === $usuario_valido && $contrasena === $contrasena_valida) {
        $_SESSION['admin'] = $usuario;
        header("Location: gestionar_productos.php");
        exit;
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container" style="max-width: 400px;">
    <h2>Acceso al panel</h2>
    <?php if ($mensaje): ?>
      <div class="alert alert-danger"><?= $mensaje ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Usuario</label>
        <input type="text" name="usuario" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Contraseña</label>
        <input type="password" name="contrasena" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Iniciar sesión</button>
    </form>
  </div>
</body>
</html>
