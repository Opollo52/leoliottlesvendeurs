<?php
session_start();
include('../includes/header.php');
?>

<link rel="stylesheet" href="../assets/css/cart.css">

<div class="container">
    <main class="main">
        <div class="section-title">Votre panier</div>

        <?php if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
            <p style="text-align:center; color: #ccc;">Votre panier est vide.</p>
        <?php else: ?>
            <div class="cart-grid">
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $id => $item):
                    $itemTotal = $item['price'] * $item['quantity'];
                    $total += $itemTotal;
                ?>
                    <div class="cart-item">
                        <div class="cart-info">
                            <h3><?= htmlspecialchars($item['title']) ?></h3>
                            <p>Prix unitaire : <?= number_format($item['price'], 2) ?> €</p>
                            <form action="update_cart.php" method="post" class="update-form">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                                <button type="submit" class="update-btn">Mettre à jour</button>
                            </form>
                            <p>Sous-total : <?= number_format($itemTotal, 2) ?> €</p>
                        </div>
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button class="remove-btn">Supprimer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-total">
                <div class="cart-total-inner">
                    <h2>Total : <?= number_format($total, 2) ?> €</h2>
                    <div class="cart-actions">
                        <form action="clear_cart.php" method="post">
                            <button class="clear-btn">Vider le panier</button>
                        </form>
                        <a href="home.php" class="return-btn">Retour à l'accueil</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php include('../includes/footer.php'); ?>
