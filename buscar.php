<?php
session_start(); // Inicia la sesión
include("includes/header.php"); // Cabecera común
include("includes/db.php"); // Conexión a la base de datos

// Captura el término de búsqueda desde la URL (?q=...)
$termino = trim($_GET['q'] ?? '');

$resultados = [];

if ($termino !== '') {
    // Añade comodines % para la búsqueda con LIKE
    $terminoLike = '%' . $termino . '%';

    // Busca productos cuyo nombre contenga el término
    $stmt = $pdo->prepare("SELECT * FROM productos 
                           WHERE nombre LIKE :termino");
    $stmt->execute([':termino' => $terminoLike]);
    $resultados = $stmt->fetchAll(); // Guarda resultados en un array
}
?>

<div class="container mt-5">
    <h2>Resultados de búsqueda para: <em><?= htmlspecialchars($termino) ?></em></h2>

    <?php if (count($resultados) > 0): ?>
        <div class="row mt-4">
            <?php foreach ($resultados as $producto): ?>
                <div class="col-md-6 col-lg-4 p-3">
                    <div class="card h-100">
                        <img src="<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                            <p class="card-text"><?= number_format($producto['precio'], 2) ?> €</p>
                            <!-- Botón para agregar al carrito -->
                            <form action="carrito.php" method="POST" class="mt-auto">
                                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm">Comprar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted mt-4">No se encontraron productos que coincidan con tu búsqueda.</p>
    <?php endif; ?>
</div>

<?php include("includes/footer.php"); // Pie de página común ?>
