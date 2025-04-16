<?php 
session_start();
require('../includes/database.php');

// ❗ Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = (float) $_POST['price'];
    $quantity = (int) $_POST['quantity'];

    // Ajouter au panier dans la session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = [
            'title' => $title,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    // Enregistrer aussi dans la BDD
    $userId = $_SESSION['user']['user_id'];

    $stmt = $conn->prepare("SELECT * FROM cart_items WHERE user_id = ? AND movie_id = ?");
    $stmt->execute([$userId, $id]);

    if ($stmt->fetch()) {
        $update = $conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND movie_id = ?");
        $update->execute([$quantity, $userId, $id]);
    } else {
        $insert = $conn->prepare("INSERT INTO cart_items (user_id, movie_id, quantity) VALUES (?, ?, ?)");
        $insert->execute([$userId, $id, $quantity]);
    }

    header('Location: cart.php');
    exit;
}
