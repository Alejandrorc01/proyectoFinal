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
<!--     meter id de ClientID de paypal -->
<!-- https://developer.paypal.com/dashboard/applications/sandbox -->
<!-- https://developer.paypal.com/dashboard/accounts     (ver cuentas)-->
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
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= number_format($total, 2, '.', '') ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Pago completado por: ' + details.payer.name.given_name);
                    window.location.href = 'procesar_pago.php';
                });
            }
        }).render('#paypal-button-container');
    </script>

    <?php include "includes/footer.php"; ?>
</body>
</html>
