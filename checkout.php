<?php
session_start(); // Inicia sesión
require_once "includes/db.php"; // Conexión a la base de datos

// Verifica que el carrito no esté vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php"); // Redirige si no hay productos
    exit;
}

// Calcula el total a pagar sumando los subtotales de cada producto
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
    <!-- SDK de PayPal con client-id de prueba -->
    <script src="https://www.paypal.com/sdk/js?client-id=AdilfXbL6CWsYxitboLzeZrbW7eHrCs1gHqZ1YdoRwgueMGyG3Wj6Pj5HuZe3CZZSN4RlnbvClA7h6zC&currency=EUR"></script>
</head>

<body>
    <?php include "includes/header.php"; // Cabecera común 
    ?>

    <div class="container mt-5 d-flex flex-column align-items-center">
        <h2 class="titulo text-center mb-3">Finalizar compra con PayPal</h2>
        <p class="text-center"><strong>Total a pagar:</strong> <?= number_format($total, 2) ?> €</p>
        <div id="paypal-button-container" style="max-width: 400px; width: 100%;"></div>
    </div>




    <script>
        // Configuración del botón de PayPal
        paypal.Buttons({
            // Crea la orden de pago con el total
            createOrder: async function(data, actions) {
                try {
                    return await actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?= number_format($total, 2, '.', '') ?>' // sin coma decimal
                            }
                        }]
                    });
                } catch (err) {
                    console.error("Error al crear la orden:", err);
                }
            },

            // Captura la orden después del pago
            onApprove: async function(data, actions) {
                try {
                    const details = await actions.order.capture();

                    // Envía los detalles del pago a PHP
                    const response = await fetch('procesar_pago.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            nombre: details.payer.name.given_name,
                            email: details.payer.email_address,
                            paypal_id: details.id
                        })
                    });

                    // Si todo sale bien, redirige a la página de agradecimiento
                    if (response.ok) {
                        window.location.href = 'gracias.php';
                    } else {
                        alert("Error al guardar el pedido.");
                    }
                } catch (err) {
                    console.error("Error al capturar el pago:", err);
                    alert("Hubo un error al procesar el pago.");
                }
            },

            // En caso de error general
            onError: function(err) {
                console.error("Error general de PayPal:", err);
                alert("Error en el proceso de pago. Inténtalo más tarde.");
            }
        }).render('#paypal-button-container'); // Renderiza el botón en el contenedor
    </script>

    <?php include "includes/footer.php"; ?>
</body>

</html>