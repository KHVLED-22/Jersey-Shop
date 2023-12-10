<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'ecommerce';

try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$query = $_POST['query'];

$sql = "SELECT *
        FROM categorie
        WHERE libelle LIKE :query";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Add the HTML structure for the table -->
<table class="table table-striped table-hover">
    
    <tbody>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= $row["libelle"] ?></td>
                <td><?= $row["description"] ?></td>
                <td>
                    <!-- Assuming the 'icone' field contains the relative path to the icon images -->
                    <img class="card-img-top w-75 mx-auto icon-image" src="assets/favicon/<?= $row['icone'] ?>" alt="Icon">
                </td>
                <td><?= $row["date_creation"] ?></td>
                <td>
                    <a href="modifier_categorie.php?id=<?= $row['id'] ?>" class="btn btn-primary">Modifier</a>
                    <a href="supprimer_categorie.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Voulez-vous vraiment supprimer la catégorie <?= $row['libelle'] ?>');"
                        class="btn btn-danger">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
