<?php
include('../includes/header.php');
require('../includes/database.php');

$allowedSorts = ['asc', 'desc'];
$sort = '';
$genreFilter = '';

if (isset($_GET['sort_price']) && in_array($_GET['sort_price'], $allowedSorts)) {
    $sort = 'ORDER BY price ' . $_GET['sort_price'];
} elseif (isset($_GET['sort_name']) && in_array($_GET['sort_name'], $allowedSorts)) {
    $sort = 'ORDER BY title ' . $_GET['sort_name'];
} elseif (isset($_GET['sort_genre']) && in_array($_GET['sort_genre'], [
    'Drama', 'Crime', 'Action', 'Sci-Fi', 'Thriller', 'Animation',
    'Biography', 'Western', 'Mystery', 'Comedy', 'Romance', 'Adventure', 'War'
])) {
    $genreFilter = 'WHERE genre = ' . $conn->quote($_GET['sort_genre']);
}

$sql = "SELECT * FROM movie $genreFilter $sort";
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <link rel="stylesheet" href="../assets/css/category.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2>Filtres</h2>
            <form method="get" class="film-filter-form">
                <label for="sort_price">Trier par prix :</label>
                <select name="sort_price" id="sort_price" onchange="this.form.submit()">
                    <option value="">Aucun tri</option>
                    <option value="asc" <?php if ($_GET['sort_price'] == 'asc') echo 'selected'; ?>>Prix croissant</option>
                    <option value="desc" <?php if ($_GET['sort_price'] == 'desc') echo 'selected'; ?>>Prix décroissant</option>
                </select>
                <label for="sort_name">Trier par nom :</label>
                <select name="sort_name" id="sort_name" onchange="this.form.submit()">
                    <option value="">Aucun tri</option>
                    <option value="asc" <?php if ($_GET['sort_name'] == 'asc') echo 'selected'; ?>>A → Z</option>
                    <option value="desc" <?php if ($_GET['sort_name'] == 'desc') echo 'selected'; ?>>Z → A</option>
                </select>
                <label for="sort_genre">Genre :</label>
                <select name="sort_genre" id="sort_genre" onchange="this.form.submit()">
                    <option value="">Aucun tri</option>
                    <?php
                    $genres = ['Drama', 'Crime', 'Action', 'Sci-Fi', 'Thriller', 'Animation', 'Biography', 'Western', 'Mystery', 'Comedy', 'Romance', 'Adventure', 'War'];
                    foreach ($genres as $genre) {
                        $selected = (isset($_GET['sort_genre']) && $_GET['sort_genre'] === $genre) ? 'selected' : '';
                        echo "<option value=\"$genre\" $selected>$genre</option>";
                    }
                    ?>
                </select>
            </form>
        </aside>

        <main class="main">
            <section class="hero-banner">
                <img src="https://thumb.canalplus.pro/http/unsafe/1440x810/filters:quality(80)/canalplus-cdn.canal-plus.io/p1/unit/25555449/canal-ouah_50001/STD169/myCANAL_Cover_mob_1920x1080-c2fC" alt="" class="hero-image">
                <div class="hero-content">
                    <h1>Le Comte de Monte-Cristo</h1>
                    <p>Victime d’un complot, le jeune Edmond Dantès est arrêté le jour de son mariage pour un crime qu’il n’a pas commis...</p>
                </div>
            </section>

            <?php foreach ($groupedMovies as $genre => $films): ?>
                <div class="section-title"><?= htmlspecialchars($genre) ?></div>
                <div class="film-grid">
                    <?php foreach ($films as $film): ?>
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
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>
