<?php
session_start(); // Inicia la sesión para acceder al carrito

// Verifica que se haya recibido un ID válido por POST
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: carrito.php"); // Redirige si no hay ID válido
    exit;
}

$id = (int)$_POST['id']; // Convierte el ID a entero

// Si no existe el carrito en la sesión, lo crea como array vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si el producto no está en el carrito, lo añade con cantidad 1.
// Si ya está, incrementa su cantidad en 1.
if (!isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id] = 1;
} else {
    $_SESSION['carrito'][$id]++;
}

// Redirige de vuelta al carrito
header("Location: carrito.php");
exit;
