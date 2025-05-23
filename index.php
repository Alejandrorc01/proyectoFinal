<?php
session_start();
$titulo = "Inicio";
require_once "includes/db.php";

$mensaje_bienvenida = false;
if (isset($_GET['login']) && isset($_SESSION['usuario'])) {
    $mensaje_bienvenida = true;
}

include("includes/header.php");
?>

<?php if ($mensaje_bienvenida): ?>
  <div class="alert alert-success text-center" id="bienvenida">
    ¡Hola, <?= htmlspecialchars($_SESSION['usuario']) ?>! Has iniciado sesión correctamente.
  </div>
<?php endif; ?>

<div class="contenedorgeneral">
  <br />
  <h1>Nuestros destacados</h1>
  <div class="row justify-content-center">
    <?php
    $stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC LIMIT 3");
    while ($producto = $stmt->fetch()):
    ?>
      <div class="col-sm-12 col-lg-4 p-3">
        <div class="card h-100 text-center">
          <a href="videojuegos.php" class="text-decoration-none text-dark">
            <div class="card-body">
              <img class="img-fluid" src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" />
              <h5 class="card-title mt-3"><?= htmlspecialchars($producto['nombre']) ?></h5>
              <p class="card-text textotarjetas"><?= htmlspecialchars($producto['descripcion']) ?></p>
              <p class="fw-bold"><?= number_format($producto['precio'], 2) ?> €</p>
              <div class="d-grid gap-2">
                <span class="btn btn-success">Cómpralo ya</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Tarjetas de acceso directo -->
  <div class="row justify-content-center mt-5">
    <div class="col-sm-12 col-md-6 col-lg-4 p-3">
      <a href="videojuegos.php" class="text-decoration-none">
        <div class="card text-white bg-dark h-100 text-center">
          <div class="card-body">
            <h4 class="card-title">Videojuegos</h4>
            <p class="card-text">Explora todos nuestros títulos disponibles para cada plataforma.</p>
            <span class="btn btn-light">Ir a videojuegos</span>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 p-3">
      <a href="consolas.php" class="text-decoration-none">
        <div class="card text-white bg-dark h-100 text-center">
          <div class="card-body">
            <h4 class="card-title">Consolas</h4>
            <p class="card-text">Elige tu consola favorita y empieza a jugar hoy mismo.</p>
            <span class="btn btn-light">Ver consolas</span>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- Oferta destacada -->
  <div id="banner" class="alert alert-warning text-center border border-white" role="alert"
       style="background-color: #198754; color: #fff">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <h4 class="alert-heading">¡No te pierdas nuestra mejor oferta semanal!</h4>
    <p class="mb-0">¡Descuento de un <strong>20%</strong> en la PS5 Slim!</p>
  </div>

  <!-- Carrusel -->
  <div class="container my-5">
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="imagenesindex/PS5-Slim-Hero-3.webp" class="d-block w-100" alt="PS5 Oferta" />
          <div class="carousel-caption">
            <h5><a href="consolas.php" class="btn btn-light btn-sm">Cómprala ya</a></h5>
            <p class="precio">NUEVO PRECIO: 499.99€</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="imagenesindex/303490_00_3.jpg" class="d-block w-100" alt="PS5 Oferta 2" />
          <div class="carousel-caption">
            <h5><a href="consolas.php" class="btn btn-light btn-sm">Cómprala ya</a></h5>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <!-- CTA final -->
  <div class="text-center mt-5">
    <h3>¿Quieres ver todo nuestro catálogo?</h3>
    <a id="gapfinal" href="videojuegos.php" class="btn btn-dark btn-lg">Ir a todos los videojuegos</a>
  </div>
</div>

<?php include("includes/footer.php"); ?>
