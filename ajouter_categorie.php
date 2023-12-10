<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Ajouter catégorie</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h4>Ajouter catégorie</h4>
    <?php
        if(isset($_POST['ajouter'])){
            $libelle = $_POST['libelle'];
            $description = $_POST['description'];

            // Check if an image file was uploaded
            if(isset($_FILES['icone']) && $_FILES['icone']['error'] == 0){
                $iconFileName = $_FILES['icone']['name'];
                $iconTempPath = $_FILES['icone']['tmp_name'];
                $iconPath = '' . $iconFileName;

                // Move the uploaded file to the specified directory
                move_uploaded_file($iconTempPath, __DIR__ . $iconPath);
            } else {
                $iconPath = ''; // Set a default value if no file is uploaded
            }

            if(!empty($libelle) && !empty($description)){
                require_once 'include/database.php';
                $sqlState = $pdo->prepare('INSERT INTO categorie(libelle, description, icone) VALUES(?, ?, ?)');
                $sqlState->execute([$libelle, $description, $iconPath]);
                header('location: categories.php');
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    Libelle and description are required.
                </div>
                <?php
            }
        }
    ?>
    <form method="post" enctype="multipart/form-data">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="libelle" required>

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" required></textarea>

        <label class="form-label">Icône</label>
        <input type="file" class="form-control" name="icone" accept="image/*" required>

        <input type="submit" value="Ajouter catégorie" class="btn btn-primary my-2" name="ajouter">
    </form>
</div>
</body>
</html>
