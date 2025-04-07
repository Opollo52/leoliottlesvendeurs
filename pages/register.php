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
</head>
<body>
    <form method="POST">
        <label>Pseudo :</label>
        <input type="text" name="username" required>

        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Mot de passe :</label>
        <input type="password" name="password" required>

        <button type="submit">Créer mon compte</button>

        <?php if(isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>