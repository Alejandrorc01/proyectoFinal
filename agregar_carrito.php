<?php
session_start();

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: carrito.php");
    exit;
}

$id = (int)$_POST['id'];

// Inicializa el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Añade o incrementa el producto en el carrito
if (!isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id] = 1;
} else {
    $_SESSION['carrito'][$id]++;
}

header("Location: carrito.php");
exit;
