<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Connexion</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
<?php

if (isset($_POST['connexion'])) {
    $login = $_POST['login'];
    $pwd   = $_POST['password'];

    if (!empty($login) && !empty($pwd)) {
        require_once 'include/database.php';

        // Check in the 'admin' table
        $adminState = $pdo->prepare('SELECT * FROM admin
                                    WHERE login=?
                                    AND   password=?');
        $adminState->execute([$login, $pwd]);

        // Check in the 'utilisateur' table if not found in 'admin'
        if ($adminState->rowCount() >= 1) {
            $adminData = $adminState->fetch();
            $_SESSION['utilisateur'] = $adminData;
            header('location: index.php');
        } else {
            $userState = $pdo->prepare('SELECT * FROM utilisateur
                                        WHERE login=?
                                        AND   password=?');
            $userState->execute([$login, $pwd]);

            if ($userState->rowCount() >= 1) {
                $userData = $userState->fetch();
                $_SESSION['utilisateur'] = $userData;
                header('location: front/index.php');
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    Login or password incorrect.
                </div>
                <?php
            }
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Login and password are required.
        </div>
        <?php
    }
}

// Check if an admin is connected to display the deconnexion button
if (isset($_SESSION['utilisateur']) && ($_SESSION['utilisateur']['login'] == 'imem' || $_SESSION['utilisateur']['login'] == 'khaled')) {
    // Display the deconnexion button
    ?>
    <form method="post">
        <input type="submit" value="Déconnexion" class="btn btn-danger" name="deconnexion ">
    </form>
    <?php
}

// Handle the deconnexion logic
if (isset($_POST['deconnexion'])) {
    session_destroy();
    header('location: index.php'); // Redirect to the main page after logout
}
?>



    <h4>Connexion</h4>
    <style>
    .small-input {
        width: 250px; /* You can adjust the width as needed */
    }
</style>

<form method="post">
    <label class="form-label" style="font-size: 14px;">Login</label>
    <input type="text" class="form-control small-input" name="login">

    <label class="form-label" style="font-size: 14px;">Password</label>
    <input type="password" class="form-control small-input" name="password">

    <input type="submit" value="Connexion" class="btn btn-primary my-2" name="connexion">
</form>



</div>

</body>
</html>