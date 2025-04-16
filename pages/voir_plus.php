<?php
require('../includes/database.php');
include('../includes/header.php');

if (!isset($_GET['id'])) {
    echo "Film non trouvé.";
    exit;
}

$id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM movie WHERE movie_id = ?");
$stmt->execute([$id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    echo "Film introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($movie['title']) ?></title>
    <link rel="stylesheet" href="../assets/css/voir_plus.css">
</head>
<body>
    <div class="movie-container">
        <div class="movie-image">
            <img src="<?= htmlspecialchars($movie['image_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
        </div>
        <div class="movie-details">
            <h1><?= htmlspecialchars($movie['title']) ?></h1>
            <p><strong>Genre :</strong> <?= htmlspecialchars($movie['genre']) ?></p>
            <p><strong>Description :</strong>
                <?= !empty($movie['description']) ? nl2br(htmlspecialchars($movie['description'])) : 'Aucune description disponible.' ?>
            </p>

            <p><strong>Prix :</strong> <?= number_format($movie['price'], 2) ?> €</p>

            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="id" value="<?= $movie['movie_id'] ?>">
                <input type="hidden" name="title" value="<?= htmlspecialchars($movie['title']) ?>">
                <input type="hidden" name="price" value="<?= $movie['price'] ?>">
                <input type="number" name="quantity" value="1" min="1">
                <button type="submit">Ajouter au panier</button>
            </form>

            <a href="home.php" class="back-btn">← Retour</a>
        </div>
    </div>
</body>
</html>
