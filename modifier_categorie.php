<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php' ?>
    <title>Modifier catégorie</title>
</head>
<body>
<?php include 'include/nav.php' ?>
<div class="container py-2">
    <h4>Modifier catégorie</h4>
    <?php
    require_once 'include/database.php';

    // Fetch the category details
    $id = $_GET['id'];
    $sqlState = $pdo->prepare('SELECT * FROM categorie WHERE id=?');
    $sqlState->execute([$id]);
    $category = $sqlState->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['modifier'])) {
        // Get the form data
        $libelle = $_POST['libelle'];
        $description = $_POST['description'];
        
        // Handle file upload
        $icone = $category['icone']; // Default value
        if ($_FILES['icone']['error'] == 0) {
            // Delete the old icon file if it exists
            if (!empty($category['icone']) && file_exists($category['icone'])) {
                unlink($category['icone']);
            }

            // Upload the new icon
            $uploadsDirectory = 'assets/favicon/';
            $iconeName = basename($_FILES['icone']['name']);
            $uploadedFile = $uploadsDirectory . $iconeName;
            move_uploaded_file($_FILES['icone']['tmp_name'], $uploadedFile);
            $icone = $iconeName;
        }

        if (!empty($libelle) && !empty($description)) {
            // Update the category in the database
            $sqlState = $pdo->prepare('UPDATE categorie
                                       SET libelle = ?,
                                           description = ?,
                                           icone = ?
                                       WHERE id = ?');
            $sqlState->execute([$libelle, $description, $icone, $id]);
            header('location: categories.php');
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Libelle, description sont obligatoires
            </div>
            <?php
        }
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="id" value="<?php echo $category['id'] ?>">
        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle" value="<?php echo $category['libelle'] ?>">

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"><?php echo $category['description'] ?></textarea>

        <label class="form-label">Icône</label>
        <input type="file" class="form-control" name="icone">
        <?php if (!empty($category['icone'])) : ?>
            <img src="<?php echo 'assets/favicon/' . $category['icone']; ?>" alt="Current Icon" width="50">
        <?php endif; ?>

        <input type="submit" value="Modifier catégorie" class="btn btn-primary my-2" name="modifier">
    </form>
</div>
</body>
</html>
