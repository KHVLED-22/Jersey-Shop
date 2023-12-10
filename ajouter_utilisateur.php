<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Ajouter utilisateur</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h4>Ajouter admin</h4>
    <?php
    
    if (isset($_POST['ajouter'])) {
        $login = $_POST['login'];
        $pwd = $_POST['password'];
        if (!empty($login) && !empty($pwd)) {
            require_once 'include/database.php';
            $date = date('Y-m-d');
            $role="client";
            $sqlState = $pdo->prepare('INSERT INTO admin VALUES(null,?,?,?)');
            $sqlState->execute([$login, $pwd, $date]);
            // Redirection
            header('location: connexion.php');
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Login , password sont obligatoires
            </div>
            <?php
        }
    }
    ?>
    <style>
    .form-control {
        width: 250px; /* Set the width as needed */
    }
</style>

<form method="post" autocomplete="off">
    <label class="form-label">Admin name</label>
    <input type="text" class="form-control" name="login">

    <label class="form-label">Password</label>
    <input type="password" class="form-control" name="password">

    <input type="submit" value="Ajouter utilisateur" class="btn btn-primary my-2" name="ajouter">
</form>

</div>

</body>
</html>