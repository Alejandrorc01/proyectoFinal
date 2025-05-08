<?php
session_start();
include("includes/header.php");
include("includes/db.php");



// Configuración de paginación
$productosPorPagina = 6;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($paginaActual < 1) $paginaActual = 1;
$inicio = ($paginaActual - 1) * $productosPorPagina;

// Filtros desde GET
$genero = $_GET['genero'] ?? '';
$plataforma = $_GET['plataforma'] ?? '';
$precioMax = $_GET['precio'] ?? '';

$where = "categoria = 'videojuego'";
$params = [];

if ($genero && $genero !== 'Todos') {
    $where .= " AND genero = :genero";
    $params[':genero'] = $genero;
}

if ($plataforma && $plataforma !== 'Todas') {
    $where .= " AND plataforma = :plataforma";
    $params[':plataforma'] = $plataforma;
}

if (is_numeric($precioMax)) {
    $where .= " AND precio <= :precio";
    $params[':precio'] = $precioMax;
}

// Total de productos
$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE $where");
$totalStmt->execute($params);
$totalProductos = $totalStmt->fetchColumn();
$totalPaginas = ceil($totalProductos / $productosPorPagina);

// Productos para esta página
$query = "SELECT * FROM productos WHERE $where LIMIT :inicio, :cantidad";
$stmt = $pdo->prepare($query);
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindValue(':cantidad', $productosPorPagina, PDO::PARAM_INT);
$stmt->execute();
$productos = $stmt->fetchAll();
?>

<div class="container mt-5">
  <div class="row">
    <!-- Filtros -->
    <div class="col-md-4">
      <h3>Filtrar por:</h3>
      <!-- ✅ action="" envía a la misma URL correctamente -->
      <form method="GET" action="" class="border p-3 rounded bg-light">
        <div class="mb-3">
          <label for="genero" class="form-label">Género:</label>
          <select class="form-select" id="genero" name="genero">
            <option <?= $genero === '' || $genero === 'Todos' ? 'selected' : '' ?>>Todos</option>
            <option <?= $genero === 'Acción' ? 'selected' : '' ?>>Acción</option>
            <option <?= $genero === 'Aventura' ? 'selected' : '' ?>>Aventura</option>
            <option <?= $genero === 'Deportes' ? 'selected' : '' ?>>Deportes</option>
            <option <?= $genero === 'RPG' ? 'selected' : '' ?>>RPG</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="plataforma" class="form-label">Plataforma:</label>
          <select class="form-select" id="plataforma" name="plataforma">
            <option <?= $plataforma === '' || $plataforma === 'Todas' ? 'selected' : '' ?>>Todas</option>
            <option <?= $plataforma === 'PS5' ? 'selected' : '' ?>>PS5</option>
            <option <?= $plataforma === 'PS4' ? 'selected' : '' ?>>PS4</option>
            <option <?= $plataforma === 'Xbox' ? 'selected' : '' ?>>Xbox</option>
            <option <?= $plataforma === 'Switch' ? 'selected' : '' ?>>Switch</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="precio" class="form-label">Precio máximo:</label>
          <input type="range" class="form-range" id="precio" name="precio" min="0" max="100" step="1"
                 value="<?= htmlspecialchars($precioMax ?: 100) ?>">
          <span><?= htmlspecialchars($precioMax ?: 100) ?> €</span>
        </div>

        <button type="submit" class="btn btn-success">Aplicar Filtro</button>
      </form>
    </div>

    <!-- Productos -->
    <div class="col-md-8">
      <h3>Videojuegos disponibles</h3>
      <div class="row">
        <?php if (count($productos) > 0): ?>
          <?php foreach ($productos as $producto): ?>
            <div class="col-md-6 col-lg-6 p-3">
              <div class="card h-100">
                <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                  <p class="card-text"><?= number_format($producto['precio'], 2) ?> €</p>
                  <form action="carrito.php" method="POST" class="mt-auto">
                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                    <button type="submit" class="btn btn-success btn-sm">Comprar</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-muted">No se encontraron productos con esos filtros.</p>
        <?php endif; ?>
      </div>

      <!-- Paginación -->
      <nav>
        <ul class="pagination justify-content-center mt-4">
          <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <li class="page-item <?= $i == $paginaActual ? 'active' : '' ?>">
              <a class="page-link"
                 href="?pagina=<?= $i ?>&genero=<?= urlencode($genero) ?>&plataforma=<?= urlencode($plataforma) ?>&precio=<?= urlencode($precioMax) ?>">
                <?= $i ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
