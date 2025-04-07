<?php
require('../includes/database.php');

$sql = "SELECT * FROM movie";
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
    <?php foreach ($groupedMovies as $genre => $films): ?>
        <h2><?php echo htmlspecialchars($genre); ?></h2>
        <div>
            <?php foreach ($films as $film): ?>
                <div>
                    <img src="<?php echo htmlspecialchars($film['image_url']); ?>" alt="<?php echo htmlspecialchars($film['title']); ?>">
                    <h3><?php echo htmlspecialchars($film['title']); ?></h3>
                    <p>Prix : <?php echo $film['price']; ?> €</p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>