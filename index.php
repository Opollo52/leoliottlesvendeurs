<?php
    session_start();
    require('includes/database.php');

    $connectedUserId = $_SESSION['user']['user_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="pages/register.php">creer un compte</a>

    <?php if ($connectedUserId): ?>
        <a href="pages/logout.php">Déconnexion</a>
        <a href="pages/editUser.php?user_id=<?= $connectedUserId ?>">Modifier</a>
        <p>Connecté en tant que <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
    <?php else: ?>
        <a href="pages/login.php">Connexion</a>
    <?php endif; ?>
</body>
</html>