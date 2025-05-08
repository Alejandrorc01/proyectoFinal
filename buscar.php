<?php
session_start();
include("includes/header.php");
include("includes/db.php");

// Obtener término de búsqueda
$termino = trim($_GET['q'] ?? '');

$resultados = [];

if ($termino !== '') {
    $terminoLike = '%' . $termino . '%';
    $stmt = $pdo->prepare("SELECT * FROM productos 
                           WHERE nombre LIKE :termino 
                              OR descripcion LIKE :termino 
                              OR plataforma LIKE :termino 
                              OR genero LIKE :termino");
    $stmt->execute([':termino' => $terminoLike]);
    $resultados = $stmt->fetchAll();
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

<?php include("includes/footer.php"); ?>
