<div class="video-card" style="display:inline-block; width:200px; margin:15px; text-align:center;">
    <a href="video.php?id=<?= $video['id'] ?>" style="text-decoration: none; color: inherit;">
        <img src="<?= '../' . ($video['image_url'] ?: 'assets/img/No-image-available.png') ?>" 
             alt="<?= htmlspecialchars($video['title']) ?>" 
             style="width: 100%; height: auto; border-radius: 8px;">
        <h2 style="font-size: 1.1em; margin: 10px 0 5px;"><?= htmlspecialchars($video['title']) ?></h2>
        <p style="color: #333;"><?= number_format($video['price'], 2) ?> €</p>
    </a>
    <form action="../pages/add_to_cart.php" method="post">
        <input type="hidden" name="id" value="<?= $video['id'] ?>">
        <input type="hidden" name="title" value="<?= htmlspecialchars($video['title']) ?>">
        <input type="hidden" name="price" value="<?= $video['price'] ?>">
        <input type="number" name="quantity" value="1" min="1" style="width:50px;">
        <button type="submit">Ajouter au panier</button>
    </form>
</div>
