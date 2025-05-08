<?php
$titulo = "Videojuegos";
//acceso a BD y header común
include("includes/header.php");
include("includes/db.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PixelTec - Videojuegos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link rel="shortcut icon" href="imagenesindex/logo.PNG" type="image/x-icon" />
</head>

<body>
  <?php include("includes/header.php"); ?>
  <main>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-4">
          <h3>Filtrar por:</h3>
          <form>
            <div class="mb-3">
              <label for="consola" class="form-label">Consola:</label>
              <select class="form-select" id="consola">
                <option selected>Todas</option>
                <option>PS5</option>
                <option>PS4</option>
                <option>Xbox Series X</option>
                <option>Nintendo Switch</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="precio" class="form-label">Precio:</label>
              <input type="range" class="form-range custom-range-green" id="precio" min="0" max="1000" step="50" value="500" />
            </div>
            <div class="mb-3">
              <label for="valoracion" class="form-label">Valoración:</label>
              <select class="form-select" id="valoracion">
                <option selected>Selecciona</option>
                <option>⭐⭐⭐⭐⭐</option>
                <option>⭐⭐⭐⭐</option>
                <option>⭐⭐⭐</option>
                <option>⭐⭐</option>
                <option>⭐</option>
              </select>
            </div>
            <button type="submit" class="btn btn-success">Aplicar Filtro</button>
          </form>
        </div>
        <div class="col-md-8">
          <h3>Lista de Videojuegos</h3>
          <div class="row">
            <?php
            $stmt = $pdo->query("SELECT * FROM productos WHERE nombre LIKE '%videojuego%' LIMIT 12");
            while ($producto = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
              <div class="col-md-6 col-lg-4 p-3">
                <div class="card mb-3" style="height: 100%">
                  <img src="<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>" />
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                    <p class="card-text">Precio: <?= number_format($producto['precio'], 2) ?> €</p>
                    <form method="POST" action="carrito.php">
                      <input type="hidden" name="id" value="<?= $producto['id'] ?>" />
                      <button type="submit" class="btn btn-success btn-sm">Comprar</button>
                    </form>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="paginacion">
      <div class="btn-toolbar mb-3" role="toolbar">
        <div class="btn-group me-2" role="group">
          <button type="button" class="btn btn-outline-secondary active">1</button>
          <button type="button" class="btn btn-outline-secondary">2</button>
          <button type="button" class="btn btn-outline-secondary">3</button>
        </div>
      </div>
    </div>
  </main>
  <?php include("includes/footer.php"); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>

</html>