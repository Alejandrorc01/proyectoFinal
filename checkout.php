<?php
session_start();
require_once "includes/db.php";

// Validar que haya productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

// Calcular total del carrito
$total = 0;
foreach ($_SESSION['carrito'] as $id => $cantidad) {
    $stmt = $pdo->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch();
    $total += $producto['precio'] * $cantidad;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con PayPal - PixelTec</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://www.paypal.com/sdk/js?client-id=AdilfXbL6CWsYxitboLzeZrbW7eHrCs1gHqZ1YdoRwgueMGyG3Wj6Pj5HuZe3CZZSN4RlnbvClA7h6zC&currency=EUR"></script>
</head>
<body>
    <?php include "includes/header.php"; ?>

    <div class="container mt-5">
        <h2 class="titulo">Finalizar compra con PayPal</h2>
        <p><strong>Total a pagar:</strong> <?= number_format($total, 2) ?> €</p>
        <div id="paypal-button-container"></div>
    </div>

    <script>
        paypal.Buttons({
            // Crear la orden
            createOrder: async function(data, actions) {
                try {
                    return await actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?= number_format($total, 2, '.', '') ?>'
                            }
                        }]
                    });
                } catch (err) {
                    console.error("Error al crear la orden:", err);
                }
            },

            // Capturar el pago cuando el comprador lo aprueba
            onApprove: async function(data, actions) {
                try {
                    const details = await actions.order.capture();
                    alert(' Pago completado por: ' + details.payer.name.given_name);
                    window.location.href = 'procesar_pago.php';
                } catch (err) {
                    console.error("Error al capturar el pago:", err);
                    alert(" Hubo un error al procesar el pago.");
                }
            },

            // Manejo de errores generales (opcional)
            onError: function(err) {
                console.error("Error general de PayPal:", err);
                alert("Error en el proceso de pago. Inténtalo más tarde.");
            }
        }).render('#paypal-button-container');
    </script>

    <?php include "includes/footer.php"; ?>
</body>
</html>
