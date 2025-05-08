<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../includes/db.php");
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];

    // Subida de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $carpeta = "../imagenesindex/";
        $nombreImagen = basename($_FILES['imagen']['name']);
        $ruta = $carpeta . $nombreImagen;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
            // Insertar producto en la base de datos
            $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen, categoria, plataforma, genero, estado)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $nombre,
                $descripcion,
                $precio,
                'imagenesindex/' . $nombreImagen,
                $categoria,
                $plataforma,
                $genero,
                $estado
            ]);
            $mensaje = "✅ Producto añadido correctamente.";
        } else {
            $mensaje = "❌ Error al subir la imagen.";
        }
    } else {
        $mensaje = "❌ Debes seleccionar una imagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Agregar nuevo producto</h1>

    <?php if ($mensaje): ?>
      <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Nombre del producto</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Precio (€)</label>
        <input type="number" step="0.01" name="precio" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Categoría</label>
        <select name="categoria" class="form-select" required>
          <option value="">Selecciona</option>
          <option value="consola">Consola</option>
          <option value="videojuego">Videojuego</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Plataforma</label>
        <select name="plataforma" class="form-select" required>
          <option value="">Selecciona</option>
          <option value="PS5">PS5</option>
          <option value="PS4">PS4</option>
          <option value="Xbox">Xbox</option>
          <option value="Switch">Switch</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Género</label>
        <select name="genero" class="form-select" required>
          <option value="">Selecciona</option>
          <option value="Acción">Acción</option>
          <option value="Aventura">Aventura</option>
          <option value="Deportes">Deportes</option>
          <option value="RPG">RPG</option>
          <option value="Otros">Otros</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select" required>
          <option value="">Selecciona</option>
          <option value="Nuevo">Nuevo</option>
          <option value="Seminuevo">Seminuevo</option>
          <option value="Usado">Usado</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Imagen</label>
        <input type="file" name="imagen" class="form-control" accept="image/*" required>
      </div>

      <button type="submit" class="btn btn-success">Guardar producto</button>
    </form>
  </div>
</body>
</html>
