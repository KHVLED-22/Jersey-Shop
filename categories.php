<!doctype html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Liste des catégories</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Add the AJAX script -->
    <script>
        $(document).ready(function(){
            // Add an event listener for the search input
            $('.search-box input').keyup(function(){
                var query = $(this).val();

                // Use AJAX to send a request to the PHP script with the search query
                $.ajax({
                    url: 'searchcategorie.php',
                    type: 'POST',
                    data: {query: query},
                    success: function(response){
                        // Update the table body with the search results
                        $('table tbody').html(response);
                    }
                });
            });
        });
    </script>
    <style>
        .icon-image {
            width: 30px; 
            height: 30px; 
        }
    </style>
</head>

<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h2>Liste des catégories</h2>
    <a href="ajouter_categorie.php" class="btn btn-primary">Ajouter catégorie</a>
    <div class="search-box"> <br>
        <input type="text" class="form-control" placeholder="Search&hellip;">
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Libelle</th>
                <th>Description</th>
                <th>Icone</th>
                <th>Date</th>
                <th>Opérations</th>
            </tr>
        </thead>
        <tbody>
        <?php
require_once 'include/database.php';

$categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $categorie) {
    ?>
    <tr>
        <td><?php echo $categorie['id'] ?></td>
        <td><?php echo $categorie['libelle'] ?></td>
        <td><?php echo $categorie['description'] ?></td>
        <td>
            <!-- Assuming the 'icone' field contains the relative path to the icon images -->
            <img class="card-img-top w-75 mx-auto icon-image" src="assets\favicon\<?= $categorie['icone'] ?>"
                 alt="Icon">
        </td>
        <td><?php echo $categorie['date_creation'] ?></td>
        <td>
            <a href="modifier_categorie.php?id=<?php echo $categorie['id'] ?>" class="btn btn-primary">Modifier</a>
            <a href="supprimer_categorie.php?id=<?php echo $categorie['id'] ?>"
               onclick="return confirm('Voulez-vous vraiment supprimer la catégorie <?php echo $categorie['libelle'] ?>');"
               class="btn btn-danger">Supprimer</a>
        </td>
    </tr>
    <?php
}
?>





        </tbody>
    </table>
</div>

</body>
</html>