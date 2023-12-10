<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php' ?>
    <title>Connexion</title>
</head>

<body>
    <div class="container py-2">
        <?php
        // Check if any user (admin or normal user) is connected to display the deconnexion button
        if (isset($_SESSION['utilisateur'])) {
            // Display the deconnexion button
            ?>
            <form method="post">
                <input type="submit" value="Déconnexion" class="btn btn-danger" name="deconnexion">
            </form>
            <?php
        } else {
            // Display the login form if no user is connected
            if (isset($_POST['connexion'])) {
                $login = $_POST['login'];
                $pwd   = $_POST['password'];

                if (!empty($login) && !empty($pwd)) {
                    require_once 'database.php';

                    // Check in the 'admin' table
                    $adminState = $pdo->prepare('SELECT * FROM admin
                                            WHERE login=?
                                            AND   password=?');
                    $adminState->execute([$login, $pwd]);

                    // Check in the 'utilisateur' table if not found in 'admin'
                    if ($adminState->rowCount() >= 1) {
                        $adminData = $adminState->fetch();
                        $_SESSION['utilisateur'] = $adminData;
                        header('location: ../index.php');
                        exit(); // Redirect and exit to prevent further rendering
                    } else {
                        $userState = $pdo->prepare('SELECT * FROM utilisateur
                                                    WHERE login=?
                                                    AND   password=?');
                        $userState->execute([$login, $pwd]);

                        if ($userState->rowCount() >= 1) {
                            $userData = $userState->fetch();
                            $_SESSION['utilisateur'] = $userData;
                            header('location: ../front/index.php');
                            exit(); // Redirect and exit to prevent further rendering
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
        <?php } ?>

    </div>

</body>

</html>
