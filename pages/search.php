<?php
require('../includes/database.php');
include('../includes/header.php');

$query = $_GET['q'] ?? '';

if ($query) {
    $stmt = $conn->prepare("SELECT * FROM movie WHERE title LIKE :query");
    $stmt->execute(['query' => '%' . $query . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $results = [];
}
?>

<link rel="stylesheet" href="../assets/css/search.css">

<div class="search-container">
    <h2>Résultats pour : "<?= htmlspecialchars($query) ?>"</h2>

    <?php if (count($results) > 0): ?>
        <div class="film-grid">
            <?php foreach ($results as $film): ?>
                <div class="film-card">
                    <a href="voir_plus.php?id=<?= $film['movie_id'] ?>" style="text-decoration: none; color: inherit;">
                        <img src="<?= htmlspecialchars($film['image_url']) ?>" alt="<?= htmlspecialchars($film['title']) ?>" class="film-img">
                        <div class="film-info">
                            <h3><?= htmlspecialchars($film['title']) ?></h3>
                            <p><?= number_format($film['price'], 2) ?> €</p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-result">Aucun film trouvé pour votre recherche.</p>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>
