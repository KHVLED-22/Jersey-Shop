<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Récupérer les données du formulaire
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Valider les données (ajoutez vos propres règles de validation si nécessaire)

    try {
        // Connexion à la base de données
        require_once 'database.php';

        // Préparer la requête SQL d'insertion
        $insertUser = $pdo->prepare('INSERT INTO utilisateur (login, password, date_creation) VALUES (?, ?, NOW())');

        // Exécuter la requête avec les données du formulaire
        $insertUser->execute([$login, $password]);

        // Rediriger vers une page de succès, par exemple
        header('Location: connexion.php');
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de base de données
        echo 'Erreur de base de données : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php' ?>
    <title>Register</title>
</head>

<body>
    <?php include 'nav.php' ?>
    <div class="container py-2">

        <h4>Register</h4>
        <style>
            .small-input {
                width: 250px;
            }
        </style>

        <form method="post">
            <label class="form-label" style="font-size: 14px;">User name</label>
            <input type="text" class="form-control small-input" name="login" required>

            <label class="form-label" style="font-size: 14px;">Password</label>
            <input type="password" class="form-control small-input" name="password" required>

            <!-- Ajouter d'autres champs nécessaires pour l'enregistrement -->

            <input type="submit" value="Register" class="btn btn-success my-2" name="register">
        </form>
    </div>

</body>

</html>
