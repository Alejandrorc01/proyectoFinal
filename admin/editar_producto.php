<?php
session_start(); // Inicia la sesión

// Verifica si el usuario es administrador
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../includes/db.php"); // Conexión a la base de datos

// Verifica que se pase un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de producto no válido.");
}

$id = (int) $_GET['id'];

// Obtener datos del producto desde la base de datos
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) {
    die("Producto no encontrado.");
}

$mensaje = "";

// Si se envía el formulario para actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $genero = $_POST['genero'];
    $estado = $_POST['estado'];
    $nueva_imagen = $producto['imagen']; // por defecto conserva la imagen actual

    // Si se ha subido una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $carpeta = "../imagenesindex/";
        $nombreImagen = basename($_FILES['imagen']['name']);
        $ruta = $carpeta . $nombreImagen;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
            // Elimina la imagen anterior si existe
            if (file_exists("../" . $producto['imagen'])) {
                unlink("../" . $producto['imagen']);
            }
            $nueva_imagen = "imagenesindex/" . $nombreImagen;
        } else {
            $mensaje = "Error al subir la nueva imagen.";
        }
    }

    // Actualiza el producto en la base de datos
    $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, categoria = ?, plataforma = ?, genero = ?, estado = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $precio, $nueva_imagen, $categoria, $plataforma, $genero, $estado, $id]);

    $mensaje = "Producto actualizado correctamente.";

    // Recarga los datos actualizados
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
<div class="container">
    <h1 class="mb-4">Editar producto: <?= htmlspecialchars($producto['nombre']) ?></h1>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>

    <!-- Formulario para editar el producto -->
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio (€)</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select" required>
                <option value="consola" <?= $producto['categoria'] === 'consola' ? 'selected' : '' ?>>Consola</option>
                <option value="videojuego" <?= $producto['categoria'] === 'videojuego' ? 'selected' : '' ?>>Videojuego</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Plataforma</label>
            <select name="plataforma" class="form-select" required>
                <option value="PS5" <?= $producto['plataforma'] === 'PS5' ? 'selected' : '' ?>>PS5</option>
                <option value="PS4" <?= $producto['plataforma'] === 'PS4' ? 'selected' : '' ?>>PS4</option>
                <option value="Xbox" <?= $producto['plataforma'] === 'Xbox' ? 'selected' : '' ?>>Xbox</option>
                <option value="Switch" <?= $producto['plataforma'] === 'Switch' ? 'selected' : '' ?>>Switch</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Género</label>
            <select name="genero" class="form-select" required>
                <option value="Acción" <?= $producto['genero'] === 'Acción' ? 'selected' : '' ?>>Acción</option>
                <option value="Aventura" <?= $producto['genero'] === 'Aventura' ? 'selected' : '' ?>>Aventura</option>
                <option value="Deportes" <?= $producto['genero'] === 'Deportes' ? 'selected' : '' ?>>Deportes</option>
                <option value="RPG" <?= $producto['genero'] === 'RPG' ? 'selected' : '' ?>>RPG</option>
                <option value="Otros" <?= $producto['genero'] === 'Otros' ? 'selected' : '' ?>>Otros</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select" required>
                <option value="Nuevo" <?= $producto['estado'] === 'Nuevo' ? 'selected' : '' ?>>Nuevo</option>
                <option value="Seminuevo" <?= $producto['estado'] === 'Seminuevo' ? 'selected' : '' ?>>Seminuevo</option>
                <option value="Usado" <?= $producto['estado'] === 'Usado' ? 'selected' : '' ?>>Usado</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen actual:</label><br>
            <?php if ($producto['imagen']): ?>
                <img src="../<?= $producto['imagen'] ?>" width="120">
            <?php else: ?>
                (Sin imagen)
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Subir nueva imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="gestionar_productos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
