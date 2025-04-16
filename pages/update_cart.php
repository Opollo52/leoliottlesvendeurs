<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['quantity'])) {
    $id = $_POST['id'];
    $quantity = (int) $_POST['quantity'];

    if (isset($_SESSION['cart'][$id]) && $quantity > 0) {
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }
}

header('Location: cart.php');
exit;
