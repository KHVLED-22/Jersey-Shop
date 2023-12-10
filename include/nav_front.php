<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: white;
            color: black;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: black;
            text-decoration: none;
            margin: 0 15px;
        }

        .login-register-btn,
        .logout-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<nav>
<?php
// Check if a user is logged in
if (isset($_SESSION['utilisateur'])) {
    $connectedUser = $_SESSION['utilisateur']['login'];

    // Check if the user is an admin based on the admin table
    $pdo = new PDO('mysql:host=localhost;dbname=ecommerce','root','');
    $adminCheck = $pdo->prepare("SELECT * FROM admin WHERE login = ?");
    $adminCheck->execute([$connectedUser]);

    if ($adminCheck->rowCount() > 0) {
        // Display the "Go to dashboard" button
        echo '<a href="../index.php" class="btn btn-primary">Go to dashboard</a>';
    }

    // Display the rest of the content
    ?>
    <div class="d-flex justify-content-end align-items-center">
        <form method="post" action="../deconnexion.php" class="me-2">
            <button type="submit" class="btn btn-danger">Deconnexion</button>
        </form>
        <div class="welcome-message">
            <span class="text-dark">Welcome, <?php echo $connectedUser; ?></span>
        </div>
    </div>
    <?php
} else {
    // Display the Login/Register button if no user is connected
    ?>
    <div class="d-flex justify-content-end align-items-center">
        <a href="../include/connexion.php" class="btn btn-primary">Login/Register</a>
    </div>
    <?php
}

?>





</nav>

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
    <style>
    .navbar-brand h3 {
        font-family: 'VotrePolicePreferée', sans-serif; /* Remplacez 'VotrePolicePreferée' par le nom de la police que vous souhaitez utiliser */
        font-size: 24px; /* Ajustez la taille de la police selon vos préférences */
        font-weight: bold; /* Ajustez le poids de la police selon vos préférences */
        color: #333; /* Ajustez la couleur de la police selon vos préférences */
        /* Autres styles de la police que vous souhaitez appliquer */
    }
</style>

<a class="navbar-brand" href="../front/index.php"><h3>Jersey Shop</h3></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                </li>
            </ul>
        </div>

        <?php
        $productCount = 0;
        if (isset($_SESSION['utilisateur'])) {
            $idUtilisateur = $_SESSION['utilisateur']['id'];
            $productCount = count($_SESSION['panier'][$idUtilisateur] ?? []);
        }
        function calculerRemise($prix, $discount)
        {
            return $prix - (($prix * $discount) / 100);
        }
        ?>
        <a class="btn float-end" href="panier.php"><i class="fa-solid fa-cart-shopping"></i> Panier
            (<?php echo $productCount; ?>)</a>
    </div>
</nav>

<!-- Add your additional HTML content here -->

</body>

</html>
