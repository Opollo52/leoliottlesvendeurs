<?php
include('../includes/header.php');
require('../includes/database.php');

$sql = "SELECT * FROM movie ORDER BY genre, title";
$stmt = $conn->query($sql);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

$groupedMovies = [];
foreach ($movies as $movie) {
    $genre = $movie['genre'];
    if (!isset($groupedMovies[$genre])) {
        $groupedMovies[$genre] = [];
    }
    $groupedMovies[$genre][] = $movie;
}
?>

<link rel="stylesheet" href="../assets/css/home.css">

<!-- Hero Banner -->
<section class="hero-banner">
    <img src="../assets/img/film.jpg"
         alt="Cinéma en vedette"
         class="hero-image">
    <div class="hero-content">
        <h1>Les nouveautés cinéma</h1>
        <p>Découvrez les derniers chefs-d’œuvre disponibles à l’achat ou en location.</p>
        <div class="hero-buttons">
            <a href="#films" class="watch-btn">Voir les films</a>
            <a href="cart.php" class="download-btn">Mon panier</a>
        </div>
    </div>
</section>

<!-- Catalogue -->
<div class="container">
    <main class="main" id="films">
        <div class="section-title">Catalogue des films</div>
        <?php foreach ($groupedMovies as $genre => $films): ?>
            <div class="film-grid">
                <?php foreach ($films as $film): ?>
                    <div class="film-card">
                        <a href="voir_plus.php?id=<?= $film['movie_id'] ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= htmlspecialchars($film['image_url']) ?>"
                                 onerror="this.onerror=null;this.src='assets/img/No-image-available.png';"
                                 alt="<?= htmlspecialchars($film['title']) ?>"
                                 class="film-img">
                            <div class="film-info">
                                <h3><?= htmlspecialchars($film['title']) ?></h3>
                                <p><?= number_format($film['price'], 2) ?> €</p>
                            </div>
                        </a>
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="id" value="<?= $film['movie_id'] ?>">
                            <input type="hidden" name="title" value="<?= htmlspecialchars($film['title']) ?>">
                            <input type="hidden" name="price" value="<?= $film['price'] ?>">
                            <input type="number" name="quantity" value="1" min="1" style="width:50px;">
                            <button type="submit">Ajouter au panier</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </main>
</div>

<?php include('../includes/footer.php'); ?>
