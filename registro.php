<?php
// registro.php
session_start(); // Inicia la sesión para mostrar mensajes o manejar datos del usuario
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - PixelTec</title>
  <!-- Enlaza hoja de estilos propia -->
  <link rel="stylesheet" href="style.css">
  <!-- Enlaza Bootstrap para estilos responsivos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Script con funciones JS (modo oscuro, mostrar contraseña, etc.) -->
  <script src="script.js" defer></script>
</head>
<!-- Aplica clase dark-mode si la cookie lo indica -->
<body class="<?= (isset($_COOKIE['modo']) && $_COOKIE['modo'] === 'oscuro') ? 'dark-mode' : '' ?>">
  <?php include("includes/header.php"); // Cabecera común de la web ?>

  <div class="container mt-5 contenedorgeneral p-4 rounded shadow">
    <h1 class="titulo text-center mb-4">Crear una cuenta</h1>

    <!-- Formulario de registro que envía datos a procesar_registro.php -->
    <form action="procesar_registro.php" method="POST" class="mx-auto" style="max-width: 500px;">

      <!-- Campo nombre de usuario con validación -->
      <div class="mb-3">
        <label for="usuario" class="form-label-login">Nombre de usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" required
               pattern="^[a-zA-Z0-9_]{4,20}$"
               title="Letras, números o guiones bajos (4-20 caracteres)">
      </div>

      <!-- Campo email con validación de formato -->
      <div class="mb-3">
        <label for="email" class="form-label-login">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required
               pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
               title="Introduce un correo válido">
      </div>

      <!-- Campo teléfono: solo 9 números -->
      <div class="mb-3">
        <label for="telefono" class="form-label-login">Teléfono</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" required
               pattern="^[0-9]{9}$"
               title="Introduce un número de teléfono de 9 dígitos">
      </div>

      <!-- Dirección mínima de 5 caracteres -->
      <div class="mb-3">
        <label for="direccion" class="form-label-login">Dirección</label>
        <input type="text" class="form-control" id="direccion" name="direccion" required
               minlength="5"
               title="Introduce una dirección válida">
      </div>

      <!-- Contraseña con validación (mínimo 6 caracteres, letras y números) -->
      <div class="mb-3">
        <label for="password" class="form-label-login">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required
               pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
               title="Debe contener al menos 6 caracteres, incluyendo letras y números">
      </div>

      <!-- Confirmación de contraseña -->
      <div class="mb-3">
        <label for="confirmar_password" class="form-label-login">Confirmar contraseña</label>
        <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
      </div>

      <!-- Checkbox para mostrar/ocultar contraseña (JS) -->
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="verPassword">
        <label class="form-check-label" for="verPassword">Mostrar contraseñas</label>
      </div>

      <!-- Botón para enviar el formulario -->
      <button type="submit" class="btn btn-success w-100">Registrarse</button>

      <!-- Enlace a login si ya tienes cuenta -->
      <a href="login.php" class="btn btn-outline-azul w-100 mt-3">¿Ya tienes cuenta? Inicia sesión</a>
    </form>
  </div>

  <?php include("includes/footer.php"); // Pie de página común ?>
</body>
</html>
