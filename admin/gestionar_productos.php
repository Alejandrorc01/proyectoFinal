<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../includes/db.php");

// Eliminar producto si se solicita
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];

    // Eliminar imagen si existe
    $stmt_img = $pdo->prepare("SELECT imagen FROM productos WHERE id = ?");
    $stmt_img->execute([$id]);
    $imagen = $stmt_img->fetchColumn();
    if ($imagen && file_exists("../$imagen")) {
        unlink("../$imagen");
    }

    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $mensaje = "✅ Producto eliminado correctamente.";
}

// Obtener productos
$stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC");
$productos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1>Gestión de productos</h1>

    <?php if (!empty($mensaje)): ?>
      <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Categoría</th>
          <th>Plataforma</th>
          <th>Género</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $producto): ?>
          <tr>
            <td><?= $producto['id'] ?></td>
            <td>
              <?php if (!empty($producto['imagen'])): ?>
                <img src="../<?= $producto['imagen'] ?>" width="60" alt="imagen">
              <?php else: ?>
                (Sin imagen)
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($producto['nombre']) ?></td>
            <td><?= number_format($producto['precio'], 2) ?> €</td>
            <td><?= ucfirst($producto['categoria']) ?></td>
            <td><?= htmlspecialchars($producto['plataforma'] ?? '') ?></td>
            <td><?= htmlspecialchars($producto['genero'] ?? '') ?></td>
            <td><?= htmlspecialchars($producto['estado'] ?? '') ?></td>
            <td>
              <a href="editar_producto.php?id=<?= $producto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
              <a href="gestionar_productos.php?eliminar=<?= $producto['id'] ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <a href="agregar_producto.php" class="btn btn-primary">+ Añadir nuevo producto</a>
  </div>
</body>
</html>
