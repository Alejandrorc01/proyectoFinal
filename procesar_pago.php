<?php
session_start();
require_once "includes/db.php";

if (empty($_SESSION['carrito'])) {
    die("El carrito está vacío.");
}

try {
    $pdo->beginTransaction();

    // Insertar pedido simulado (puedes capturar datos reales si usas más info de PayPal)
    $stmt = $pdo->prepare("INSERT INTO pedidos (nombre, direccion, email) VALUES (?, ?, ?)");
    $stmt->execute([
        'Cliente PayPal (simulado)',
        'Pago confirmado por PayPal Sandbox',
        'paypal@ejemplo.com'
    ]);
    $pedido_id = $pdo->lastInsertId();

    // Insertar productos del carrito
    $stmtDetalle = $pdo->prepare("INSERT INTO pedido_detalle (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");

    foreach ($_SESSION['carrito'] as $producto_id => $cantidad) {
        $stmtDetalle->execute([$pedido_id, $producto_id, $cantidad]);
    }

    $pdo->commit();
    unset($_SESSION['carrito']);
    echo "<h2>¡Pedido confirmado! Gracias por tu compra.</h2>";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error al guardar el pedido: " . $e->getMessage();
}
