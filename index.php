<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'include/head.php' ?>
    <title>Accueil</title>
    <!-- Updated styles -->
    <style>
        body {
            background-color: #f0f0f0; /* Set your desired background color */
            font-family: 'Arial', sans-serif;
        }

        .jumbotron {
            background-color: #3498db; /* Set your desired jumbotron background color */
            color: #fff; /* Set text color for jumbotron */
            padding: 20px;
            border-radius: 10px;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <?php include 'include/nav.php' ?>
    <div class="container py-5 text-center">
        <?php
        if (isset($_SESSION['utilisateur']) && isset($_SESSION['utilisateur']['username'])) {
            $username = $_SESSION['utilisateur']['username'];
            ?>
            <div class="jumbotron">
                <h1 class="display-4">Bienvenue, <?php echo $username; ?>!</h1>
            </div>
            <?php
        } else {
            ?>
            <div class="jumbotron">
                <h1 class="display-4">Bienvenue !</h1>
            </div>
            <?php
        }
        ?>
    </div>
</body>

</html>
