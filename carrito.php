<?php
session_start();
include("includes/header.php");
include("includes/db.php");

// Inicializar carrito
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $idEliminar = (int)$_GET['eliminar'];
    unset($_SESSION['carrito'][$idEliminar]);
    header("Location: carrito.php");
    exit;
}

// Obtener productos
$productos = [];
$total = 0.0;

if (!empty($_SESSION['carrito'])) {
    $ids = array_keys($_SESSION['carrito']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $productosBD = $stmt->fetchAll();

    foreach ($productosBD as $producto) {
        $cantidad = $_SESSION['carrito'][$producto['id']];
        $producto['cantidad'] = $cantidad;
        $producto['subtotal'] = $producto['precio'] * $cantidad;
        $productos[] = $producto;
        $total += $producto['subtotal'];
    }
}
?>

<div class="container mt-5">
  <h2>🛒 Tu carrito</h2>
  <hr>

  <?php if (empty($productos)): ?>
    <p class="text-muted">Tu carrito está vacío.</p>
    <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
  <?php else: ?>
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Imagen</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Subtotal</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $producto): ?>
          <tr>
            <td><img src="<?= $producto['imagen'] ?>" width="60"></td>
            <td><?= htmlspecialchars($producto['nombre']) ?></td>
            <td><?= $producto['cantidad'] ?></td>
            <td><?= number_format($producto['precio'], 2) ?> €</td>
            <td><?= number_format($producto['subtotal'], 2) ?> €</td>
            <td>
              <a href="carrito.php?eliminar=<?= $producto['id'] ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('¿Eliminar este producto del carrito?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="4" class="text-end fw-bold">Total:</td>
          <td colspan="2"><strong><?= number_format($total, 2) ?> €</strong></td>
        </tr>
      </tbody>
    </table>
    <div class="text-end">
      <a href="checkout.php" class="btn btn-success">Finalizar compra</a>
    </div>
  <?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>
