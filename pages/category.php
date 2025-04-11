<?php
    include('../includes/header.php');
?>

<?php
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
    <title>Document</title>
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
                    <option value="Drama" <?php if ($_GET['sort_genre'] == 'Drama') echo 'selected'; ?>>Drama</option>
                    <option value="Crime" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Crime') echo 'selected'; ?>>Crime</option>
                    <option value="Action" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Action') echo 'selected'; ?>>Action</option>
                    <option value="Sci-Fi" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Sci-Fi') echo 'selected'; ?>>Sci-Fi</option>
                    <option value="Thriller" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Thriller') echo 'selected'; ?>>Thriller</option>
                    <option value="Animation" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Animation') echo 'selected'; ?>>Animation</option>
                    <option value="Biography" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Biography') echo 'selected'; ?>>Biography</option>
                    <option value="Western" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Western') echo 'selected'; ?>>Western</option>
                    <option value="Mystery" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Mystery') echo 'selected'; ?>>Mystery</option>
                    <option value="Comedy" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Comedy') echo 'selected'; ?>>Comedy</option>
                    <option value="Romance" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Romance') echo 'selected'; ?>>Romance</option>
                    <option value="Adventure" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'Adventure') echo 'selected'; ?>>Adventure</option>
                    <option value="War" <?php if (isset($_GET['sort_genre']) && $_GET['sort_genre'] == 'War') echo 'selected'; ?>>War</option>
                </select>
            </form>
        </aside>
        <main class="main">
            <section class="hero-banner">
                <img src="https://thumb.canalplus.pro/http/unsafe/1440x810/filters:quality(80)/canalplus-cdn.canal-plus.io/p1/unit/25555449/canal-ouah_50001/STD169/myCANAL_Cover_mob_1920x1080-c2fC" alt="" class="hero-image">
                <div class="hero-content">
                    <h1>Le Comte de Monte-Cristo</h1>
                    <p>Victime d’un complot, le jeune Edmond Dantès est arrêté le jour de son mariage pour un crime qu’il n’a pas commis. Après quatorze ans de détention au château d’If, il parvient à s’évader. Devenu immensément riche, il revient sous l’identité du comte de Monte-Cristo pour se venger des trois hommes qui l’ont trahi.</p>
                    <div class="hero-buttons">
                        <button class="watch-btn">Voir plus</button>
                        <button class="download-btn">Ajouter au panier</button>
                    </div>
                </div>
            </section>
            <?php if (isset($_GET['sort_price']) && in_array($_GET['sort_price'], ['asc', 'desc'])): ?>
                <div class="section-title">Tous les films</div>
                <div class="film-grid">
                    <?php foreach ($movies as $film): ?>
                        <div class="film-card">
                            <img src="<?php echo htmlspecialchars($film['image_url']); ?>" alt="<?php echo htmlspecialchars($film['title']); ?>" class="film-img">
                            <div class="film-info">
                                <h3><?php echo htmlspecialchars($film['title']); ?></h3>
                                <p><?php echo $film['price']; ?> €</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <?php if (isset($_GET['sort_name']) && in_array($_GET['sort_name'], ['asc', 'desc'])): ?>
                    <div class="section-title">Tous les films</div>
                    <div class="film-grid">
                        <?php foreach ($movies as $film): ?>
                            <div class="film-card">
                                <img src="<?php echo htmlspecialchars($film['image_url']); ?>" alt="<?php echo htmlspecialchars($film['title']); ?>" class="film-img">
                                <div class="film-info">
                                    <h3><?php echo htmlspecialchars($film['title']); ?></h3>
                                    <p><?php echo $film['price']; ?> €</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <?php if (isset($_GET['sort_genre']) && in_array($_GET['sort_genre'], ['Drama', 'Crime', 'Action', 'Sci-Fi', 'Thriller', 'Animation', 'Biography', 'Western', 'Mystery', 'Comedy', 'Romance', 'Adventure', 'War'])): ?>
                        <?php $genreLabel = 'Tous les films';
                            if (isset($_GET['sort_genre']) && $_GET['sort_genre'] !== '') {
                                $genreLabel = htmlspecialchars($_GET['sort_genre']);
                            }
                        ?>
                        <div class="section-title"><?php echo $genreLabel; ?></div>
                        <div class="film-grid">
                            <?php foreach ($movies as $film): ?>
                                <div class="film-card">
                                    <img src="<?php echo htmlspecialchars($film['image_url']); ?>" alt="<?php echo htmlspecialchars($film['title']); ?>" class="film-img">
                                    <div class="film-info">
                                        <h3><?php echo htmlspecialchars($film['title']); ?></h3>
                                        <p><?php echo $film['price']; ?> €</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <?php foreach ($groupedMovies as $genre => $films): ?>
                            <div class="section-title"><?php echo htmlspecialchars($genre); ?></div>
                            <div class="film-grid">
                                <?php foreach ($films as $film): ?>
                                    <div class="film-card">
                                        <img src="<?php echo htmlspecialchars($film['image_url']); ?>" alt="<?php echo htmlspecialchars($film['title']); ?>" class="film-img" >
                                        <div class="film-info">
                                            <h3><?php echo htmlspecialchars($film['title']); ?></h3>
                                            <p><?php echo $film['price']; ?> €</p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>