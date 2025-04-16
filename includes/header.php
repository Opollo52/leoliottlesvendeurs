<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$connectedUserId = $_SESSION['user']['user_id'] ?? null;
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/header.css">
</head>
<body>
    <nav class="<?= in_array($currentPage, ['category.php', 'search.php']) ? 'white-header' : '' ?>">
        <div class="nav">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo">
            <div class="droite">
                <a class="hvr" href="home.php">Accueil</a>
                <a class="hvr" href="category.php">Catégorie</a>

                <!-- Loupe affichée uniquement sur catégorie et search -->
                <?php if (in_array($currentPage, ['category.php', 'search.php'])): ?>
                <div class="container">
                    <form action="search.php" method="get" class="mainbox">
                        <div class="iconContainer">
                            <svg viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="search_icon">
                                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                            </svg>
                        </div>
                        <input class="search_input" name="q" type="text" placeholder="Rechercher ...">
                    </form>
                </div>
                <?php endif; ?>

                <a class="hvr" href="cart.php"><img class="panier" src="../assets/img/panier.png" alt="Panier"></a>

                <input type="checkbox" id="profil-toggle" />
                <label for="profil-toggle" class="profil-label hvr">
                    <img class="pdp" src="../assets/img/user.png" alt="Profil">
                </label>

                <div class="menu-profil">
                    <?php if ($connectedUserId): ?>
                        <p>Connecté en tant que <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
                        <a href="profile.php">Mon profil</a>
                        <a class="deco" href="logout.php">Déconnexion</a>
                    <?php else: ?>
                        <a href="login.php">Se connecter</a>
                        <a href="register.php">Créer un compte</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>

<script src="../assets/js/header.js"></script>
