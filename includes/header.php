<?php
// Si no se ha definido un título para la página, se establece por defecto
if (!isset($titulo)) {
  $titulo = "PixelTec";
}

// Asegura que la sesión esté iniciada (por si se incluye antes del session_start)
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $titulo ?></title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Font Awesome para iconos -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet" />

  <!-- Estilos propios -->
  <link rel="stylesheet" href="style.css" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="imagenesindex/logo.PNG" type="image/x-icon" />
</head>

<body>
  <header>
    <!-- NAVBAR PRINCIPAL -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary navegacion" data-bs-theme="dark">
      <div class="container-fluid">
        <!-- Logo PixelTec -->
        <a class="navbar-brand titulo" href="index.php">PixelTec</a>

        <!-- Botón hamburguesa en modo móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del navbar -->
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link link" href="consolas.php">Consolas</a></li>
            <li class="nav-item"><a class="nav-link link" href="videojuegos.php">Videojuegos</a></li>
            <!-- Botón para cambiar entre modo claro/oscuro -->
            <button id="modo-toggle" class="btn btn-sm btn-outline-secondary ms-3">Modo Oscuro</button>
          </ul>

          <!-- Buscador -->
          <form class="d-flex barrabusq" method="GET" action="buscar.php" role="search">
            <input class="form-control me-2" type="search" name="q" placeholder="Escribe un producto" />
            <button class="btn btn-outline-azul" type="submit">Buscar</button>
          </form>

          <!-- Iconos de carrito y perfil -->
          <div class="d-flex align-items-center">
            <!-- Icono del carrito -->
            <a class="carrito" href="carrito.php">
              <i class="fas fa-shopping-cart" style="font-size: 1.5rem; color: white;"></i>
            </a>

            <!-- Menú de usuario (dependiendo si está logueado o no) -->
            <div class="ms-3 dropdown">
              <?php if (isset($_SESSION['usuario'])): ?>
                <!-- Icono con menú desplegable si está logueado -->
                <a class="icono-perfil dropdown-toggle activo"
                   href="#"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">
                  <i class="fas fa-user-circle" style="font-size: 1.5rem; color: white;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item text-danger" href="logout.php">Cerrar sesión</a></li>
                </ul>
              <?php else: ?>
                <!-- Icono sin menú si no ha iniciado sesión -->
                <a class="icono-perfil" href="login.php">
                  <i class="fas fa-user-circle" style="font-size: 1.5rem; color: white;"></i>
                </a>
              <?php endif; ?>
            </div>
          </div> <!-- Fin d-flex align-items-center -->

        </div>
      </div>
    </nav>
  </header>
