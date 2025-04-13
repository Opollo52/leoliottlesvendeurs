<?php
    require('../includes/database.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            } else {
                $error = "Erreur lors de l'inscription.";
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
    <title>register</title>
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Créer un compte</h1>
    <form class="form" method="POST" action="register.php">
        <span class="input-span">
            <label for="username" class="label">Pseudo</label>
            <input type="text" name="username" id="username"/>
        </span>
        <span class="input-span">
            <label for="email" class="label">Email</label>
            <input type="email" name="email" id="email"/>
        </span>
        <span class="input-span">
            <label for="password" class="label">Mot de passe</label>
            <input type="password" name="password" id="password"/>
        </span>
        <input class="submit" type="submit" value="Créer un compte" />
        <span class="span">
            Déjà un compte ? <a href="login.php">Se connecter</a>
        </span>
        <?php if(isset($error)) echo "<p>$error</p>"; ?>
    </form>
    <?php include '../includes/footer.php'; ?>
</body>
</html>