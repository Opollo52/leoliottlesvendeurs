<?php
session_start();
require('..//includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Connectez-vous</h1>
    <form class="form" method="POST" action="login.php">
        <span class="input-span">
            <label for="email" class="label">Email</label>
            <input type="email" name="email" id="email"/>
        </span>
        <span class="input-span">
            <label for="password" class="label">Mot de passe</label>
            <input type="password" name="password" id="password"/>
        </span>
        <span class="span">
            <a href="#">Mot de passe oublier ?</a>
        </span>
        <input class="submit" type="submit" value="Se connecter" />
        <span class="span">
            Pas encore de compte ? <a href="register.php">Créer un compte</a>
        </span>
        <?php if(isset($error)) echo "<p>$error</p>"; ?>
    </form>
    <?php include '../includes/footer.php'; ?>
</body>
</html>