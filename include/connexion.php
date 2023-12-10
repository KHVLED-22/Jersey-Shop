<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'head.php' ?>
    <title>Connexion</title>
</head>

<body>
    <?php include 'nav.php' ?>
    <div class="container py-2">
        <?php

        //ken klet ba3dhha zid session_start() ; !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!



        if (isset($_POST['connexion'])) {
            $login = $_POST['login'];
            $pwd   = $_POST['password'];

            if (!empty($login) && !empty($pwd)) {
                require_once 'database.php';

                $adminState = $pdo->prepare('SELECT * FROM admin
                                            WHERE login=?
                                            AND   password=?');
                $adminState->execute([$login, $pwd]);

                if ($adminState->rowCount() >= 1) {
                    $adminData = $adminState->fetch();
                    $_SESSION['utilisateur'] = $adminData;
                    header('location: ../index.php');
                } else {
                    $userState = $pdo->prepare('SELECT * FROM utilisateur
                                                WHERE login=?
                                                AND   password=?');
                    $userState->execute([$login, $pwd]);

                    if ($userState->rowCount() >= 1) {
                        $userData = $userState->fetch();
                        $_SESSION['utilisateur'] = $userData;
                        header('location: ../front/index.php');
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

        if (isset($_SESSION['utilisateur']) && ($_SESSION['utilisateur']['login'] == 'imem' || $_SESSION['utilisateur']['login'] == 'khaled')) {
            ?>
            <form method="post">
                <input type="submit" value="Déconnexion" class="btn btn-danger" name="deconnexion">
            </form>
            <?php
        }

        if (isset($_POST['deconnexion'])) {
            session_destroy();
            header('location: ../front/index.php');
        }
        ?>

        <h4>Connexion</h4>
        <style>
            .small-input {
                width: 250px;
            }
        </style>

        <form method="post">
            <label class="form-label" style="font-size: 14px;">Login</label>
            <input type="text" class="form-control small-input" name="login">

            <label class="form-label" style="font-size: 14px;">Password</label>
            <input type="password" class="form-control small-input" name="password">

            <input type="submit" value="Connexion" class="btn btn-primary my-2" name="connexion">
        </form>
    <!-- Ajout du bouton Register -->
    <a href="register.php" class="btn btn-success my-2">Register</a>
    </div>

</body>

</html>
