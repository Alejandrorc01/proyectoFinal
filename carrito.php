<?php
session_start(); // Inicia la sesión para acceder al carrito
include("includes/header.php"); // Cabecera común
include("includes/db.php"); // Conexión a la base de datos

// Si no existe el carrito, se inicializa como un array vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si se ha solicitado eliminar un producto
if (isset($_GET['eliminar'])) {
    $idEliminar = (int)$_GET['eliminar'];
    unset($_SESSION['carrito'][$idEliminar]); // Elimina ese producto del carrito
    header("Location: carrito.php"); // Redirige para evitar reenvío del formulario
    exit;
}

// Si se ha solicitado modificar la cantidad
if (isset($_GET['modificar']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (isset($_SESSION['carrito'][$id])) {
        if ($_GET['modificar'] === 'sumar') {
            $_SESSION['carrito'][$id]++;
        } elseif ($_GET['modificar'] === 'restar') {
            $_SESSION['carrito'][$id]--;
            if ($_SESSION['carrito'][$id] <= 0) {
                unset($_SESSION['carrito'][$id]);
            }
        }
    }
    header("Location: carrito.php");
    exit;
}

// Inicializamos variables
$productos = []; // Lista de productos a mostrar
$total = 0.0;    // Total acumulado del carrito

// Si el carrito tiene productos
if (!empty($_SESSION['carrito'])) {
    $ids = array_keys($_SESSION['carrito']); // IDs de los productos en el carrito
    $placeholders = implode(',', array_fill(0, count($ids), '?')); // Genera ?,?,? para la consulta
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id IN ($placeholders)");
    $stmt->execute($ids); // Ejecuta consulta con los IDs
    $productosBD = $stmt->fetchAll();

    // Calcula cantidades y subtotales
    foreach ($productosBD as $producto) {
        $cantidad = $_SESSION['carrito'][$producto['id']];
        $producto['cantidad'] = $cantidad;
        $producto['subtotal'] = $producto['precio'] * $cantidad;
        $productos[] = $producto;
        $total += $producto['subtotal'];
    }
}
?>

<!-- INTERFAZ DEL CARRITO -->
<div class="container mt-5">
  <h2>Tu carrito</h2>
  <hr>

  <?php if (empty($productos)): ?>
    <p class="text-muted">Tu carrito está vacío.</p>
    <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
  <?php else: ?>
    <table class="table table-bordered text-center align-middle">
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
            <td>
              <a href="carrito.php?modificar=restar&id=<?= $producto['id'] ?>" class="btn btn-sm btn-outline-secondary">-</a>
              <span class="mx-2"><?= $producto['cantidad'] ?></span>
              <a href="carrito.php?modificar=sumar&id=<?= $producto['id'] ?>" class="btn btn-sm btn-outline-secondary">+</a>
            </td>
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
