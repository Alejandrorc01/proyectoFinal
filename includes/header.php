<?php
if (!isset($titulo)) {
  $titulo = "PixelTec";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $titulo ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link rel="shortcut icon" href="imagenesindex/logo.PNG" type="image/x-icon" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary navegacion" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand titulo" href="index.php">PixelTec</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link link" href="consolas.php">Consolas</a></li>
            <li class="nav-item"><a class="nav-link link" href="videojuegos.php">Videojuegos</a></li>
            <li class="nav-item"><a class="nav-link link" href="#">Reservas</a></li>
            <li class="nav-item"><a class="nav-link link" href="#">Ofertas</a></li>
            <li class="nav-item"><a class="nav-link link" href="#">Otros</a></li>
            <button id="modo-toggle" class="btn btn-sm btn-outline-secondary ms-3">Modo Oscuro</button>
          </ul>

          <!-- Buscador corregido -->
          <form class="d-flex barrabusq" method="GET" action="buscar.php" role="search">
            <input class="form-control me-2" type="search" name="q" placeholder="Escribe un producto" />
            <button class="btn btn-outline-azul" type="submit">Buscar</button>
          </form>

          <div><a class="carrito" href="carrito.php"><i class="fas fa-shopping-cart"></i></a></div>
        </div>
      </div>
    </nav>
  </header>
