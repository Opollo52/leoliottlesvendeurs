<?php
session_start();
require('../includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Vérification de l'utilisateur
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Connexion OK : stocke les infos en session
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];

            // Récupère le panier s'il existe en base
            $stmtCart = $conn->prepare("SELECT m.movie_id, m.title, m.price, c.quantity
                                        FROM cart_items c
                                        JOIN movie m ON m.movie_id = c.movie_id
                                        WHERE c.user_id = ?");
            $stmtCart->execute([$user['user_id']]);
            $items = $stmtCart->fetchAll();

            $_SESSION['cart'] = [];
            foreach ($items as $item) {
                $_SESSION['cart'][$item['movie_id']] = [
                    'title' => $item['title'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity']
                ];
            }

            header('Location: home.php');
            exit();
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <h1>Connectez-vous</h1>
    <form class="form" method="POST" action="login.php">
        <span class="input-span">
            <label for="email" class="label">Email</label>
            <input type="email" name="email" id="email" required />
        </span>

        <span class="input-span">
            <label for="password" class="label">Mot de passe</label>
            <input type="password" name="password" id="password" required />
        </span>

        <span class="span">
            <a href="#">Mot de passe oublié ?</a>
        </span>

        <input class="submit" type="submit" value="Se connecter" />

        <span class="span">
            Pas encore de compte ? <a href="register.php">Créer un compte</a>
        </span>

        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
