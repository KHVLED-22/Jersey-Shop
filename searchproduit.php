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
        FROM produit
        WHERE libelle LIKE :query
        OR id_categorie LIKE :query";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["libelle"] . "</td>";
    echo "<td>" . $row["prix"] . "</td>";
    echo "<td>" . $row["discount"] . "</td>";
    echo "<td>" . $row["id_categorie"] . "</td>";
    echo "<td>" . $row["date_creation"] . "</td>";
    echo "<td>" . $row["description"] . "</td>";
    echo "<td><img src='upload/produit/" . $row["image"] . "' alt='Description de l'image' width='100' height='100'></td>";
    echo "<td>" . $row["quantite"] . "</td>";
    echo '<td>
            <div class="btn-group">
                <a class="btn btn-primary" href="modifier_produit.php?id=' . $row["id"] . '">Modifier</a>
                <a class="btn btn-danger mx-1" href="supprimer_produit.php?id=' . $row["id"] . '" onclick="return confirm(\'Voulez-vous vraiment supprimer le produit ' . $row["libelle"] . ' ?\')">Supprimer</a>
            </div>
          </td>';
    echo "</tr>";
}
?>