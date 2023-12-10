<?php
// ... (incluez la connexion à la base de données et la fonction de remise si nécessaire)
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Function to calculate the discount
function calculerRemise($prix, $discount)
{
    // Add your logic to calculate the discounted price
    // For example, if the discount is 20%, apply it to the price
    $discountedPrice = $prix - ($prix * ($discount / 100));

    // Return the discounted price
    return $discountedPrice;
}

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Requête pour récupérer les produits correspondants au terme de recherche
    $sql = "SELECT p.id, p.libelle FROM produit p WHERE p.libelle LIKE :search ORDER BY p.date_creation DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo json_encode(["error" => "Erreur lors de la récupération des données"]);
    }
}
?>