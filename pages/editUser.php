<?php
    session_start();
    require('../includes/database.php');

    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

    if (!isset($_GET['user_id'])) {
        header('Location: ../index.php');
        exit();
    }  

    $user_id = (int)$_GET['user_id'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('Location: ../index.php');
        exit();
    }

    if ($_SESSION['user']['user_id'] != $user_id) {
        header('Location: ../index.php');
        exit();
    }  

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("UPDATE user SET username = ?, email = ? WHERE user_id = ?");
        $stmt->execute([$username, $email, $user_id]);

        header('Location: ../index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'utilisateur</title>
</head>
<body>
    <h2>Modifier l'utilisateur</h2>

    <form method="POST">
        <label>Pseudo :</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email :</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <button type="submit">Enregistrer</button>
    </form>
    
    <a href="../index.php">Annuler</a>
</body>
</html>
