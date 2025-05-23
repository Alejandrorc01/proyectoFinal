<?php
session_start(); // Inicia la sesión para acceder al carrito
require_once "includes/db.php"; // Conexión a la base de datos

// Lee los datos JSON enviados desde JavaScript (fetch)
$data = json_decode(file_get_contents("php://input"), true);

// Obtiene los valores del pago, o asigna por defecto si no se reciben
$nombre = $data['nombre'] ?? 'Cliente Desconocido';
$email = $data['email'] ?? 'sinemail@paypal.com';
$paypal_id = $data['paypal_id'] ?? 'N/A';

// Si el carrito está vacío, devuelve error 400 y mensaje
if (empty($_SESSION['carrito'])) {
    http_response_code(400); // Bad Request
    echo "El carrito está vacío.";
    exit;
}

try {
    // Inicia una transacción para asegurar la integridad de los datos
    $pdo->beginTransaction();

    // Inserta el pedido con los datos del comprador
    $stmt = $pdo->prepare("INSERT INTO pedidos (nombre, direccion, email) VALUES (?, ?, ?)");
    $stmt->execute([
        $nombre,
        "Pago confirmado vía PayPal (ID: $paypal_id)",
        $email
    ]);

    // Obtiene el ID del pedido insertado
    $pedido_id = $pdo->lastInsertId();

    // Inserta los productos del carrito en la tabla de detalles del pedido
    $stmtDetalle = $pdo->prepare("INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
    foreach ($_SESSION['carrito'] as $producto_id => $cantidad) {
        $stmtDetalle->execute([$pedido_id, $producto_id, $cantidad]);
    }

    // Confirma la transacción
    $pdo->commit();

    // Limpia el carrito después del pedido
    unset($_SESSION['carrito']);

    http_response_code(200); // Todo correcto
} catch (Exception $e) {
    // En caso de error, revierte la transacción y muestra mensaje
    $pdo->rollBack();
    http_response_code(500); // Error del servidor
    echo "Error al guardar el pedido: " . $e->getMessage();
}
