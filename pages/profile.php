<?php
session_start();
require('../includes/database.php');

// Redirige si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user']['user_id'];

// Récupère les infos complètes depuis la base
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="../assets/css/profil.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="profile-container">
        <h1>Mon Profil</h1>
        <div class="profile-card">
            <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
        </div>

        <a href="logout.php" class="logout-btn">Se déconnecter</a>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
