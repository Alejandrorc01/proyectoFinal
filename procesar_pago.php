<?php
session_start();
require_once "includes/db.php";

// Leer JSON recibido desde fetch
$data = json_decode(file_get_contents("php://input"), true);

// Datos simulados si algo falla
$nombre = $data['nombre'] ?? 'Cliente Desconocido';
$email = $data['email'] ?? 'sinemail@paypal.com';
$paypal_id = $data['paypal_id'] ?? 'N/A';

if (empty($_SESSION['carrito'])) {
    http_response_code(400);
    echo "El carrito está vacío.";
    exit;
}

try {
    $pdo->beginTransaction();

    // Insertar pedido con datos de PayPal
    $stmt = $pdo->prepare("INSERT INTO pedidos (nombre, direccion, email) VALUES (?, ?, ?)");
    $stmt->execute([
        $nombre,
        "Pago confirmado vía PayPal (ID: $paypal_id)",
        $email
    ]);
    $pedido_id = $pdo->lastInsertId();

    // Detalle del pedido
    $stmtDetalle = $pdo->prepare("INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
    foreach ($_SESSION['carrito'] as $producto_id => $cantidad) {
        $stmtDetalle->execute([$pedido_id, $producto_id, $cantidad]);
    }

    $pdo->commit();
    unset($_SESSION['carrito']);
    http_response_code(200); // Devuelve OK
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo "Error al guardar el pedido: " . $e->getMessage();
}
