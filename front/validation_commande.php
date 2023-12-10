<!DOCTYPE html>
<html lang="en">
<head>
<?php
session_start();
require_once '../include/database.php';
?>
<?php include '../include/nav_front.php' ?>
<div class="container py-2">
    <?php
    if (isset($_POST['vider'])) {
        $_SESSION['panier'][$idUtilisateur] = [];
        header('location: panier.php');
    }


    $idUtilisateur = $_SESSION['utilisateur']['id'] ?? 0;
    $panier = $_SESSION['panier'][$idUtilisateur] ?? [];

    if (!empty($panier)) {
        $idProduits = array_keys($panier);
        $idProduits = implode(',', $idProduits);
        $produits = $pdo->query("SELECT * FROM produit WHERE id IN ($idProduits)")->fetchAll(PDO::FETCH_ASSOC);
    }
    if (isset($_POST['valider'])) {
        $sql = 'INSERT INTO ligne_commande(id_produit,id_commande,prix,quantite,total) VALUES';
        $total = 0;
        $prixProduits = [];
        foreach ($produits as $produit) {
            $idProduit = $produit['id'];
            $qty = $panier[$idProduit];
            $discount = $produit['discount'];
            $prix = calculerRemise($produit['prix'], $discount);

            $total += $qty * $prix;
            $prixProduits[$idProduit] = [
                'id' => $idProduit,
                'prix' => $prix,
                'total' => $qty * $prix,
                'qty' => $qty
            ];
        }

        $sqlStateCommande = $pdo->prepare('INSERT INTO commande(id_client,total) VALUES(?,?)');
        $sqlStateCommande->execute([$idUtilisateur, $total]);
        $idCommande = $pdo->lastInsertId();
        $args = [];
        foreach ($prixProduits as $produit) {
            $id = $produit['id'];
            $sql .= "(:id$id,'$idCommande',:prix$id,:qty$id,:total$id),";
        }
        $sql = substr($sql, 0, -1);
        $sqlState = $pdo->prepare($sql);
        foreach ($prixProduits as $produit) {
            $id = $produit['id'];
            $sqlState->bindParam(':id' . $id, $produit['id']);
            $sqlState->bindParam(':prix' . $id, $produit['prix']);
            $sqlState->bindParam(':qty' . $id, $produit['qty']);
            $sqlState->bindParam(':total' . $id, $produit['total']);
        }
        $inserted = $sqlState->execute();

        // Insert values into commande1 table
        if ($inserted) {
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $addresse = $_POST['addresse'];
            $postalCode = $_POST['postalCode'];
            $paymentType = $_POST['paymentType'];

            try {
                $sqlCommande1 = 'INSERT INTO commande1 (email, phone, addresse, postalCode, paymentType) VALUES (?, ?, ?, ?, ?)';
                $stmtCommande1 = $pdo->prepare($sqlCommande1);
                $stmtCommande1->execute([$email, $phone, $addresse, $postalCode, $paymentType]);
            } catch (PDOException $e) {
                echo "Error inserting data into commande1: " . $e->getMessage();
                // Handle the error appropriately
            }

            $_SESSION['panier'][$idUtilisateur] = [];
            header('location: panier.php?success=true&total=' . $total);
        } else {
            ?>
            <div class="alert alert-error" role="alert">
                Erreur (contactez l'administrateur).
            </div>
            <?php
        }
    
    }
    ?>
    <?php
    if (!isset($_GET['success'])) {

        ?>
        <h4>Panier (<?php echo $productCount; ?>)</h4>
        <?php
    }
    ?>
    <?php include '../include/head.php' ?>
    <title>Command Confirmation</title>
</head>
<body>
    <div class="container py-2">
        <h4>Command Confirmation</h4>

        <form method="post" action="" autocomplete="off">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" required>

            <label class="form-label">Phone:</label>
            <input type="tel" class="form-control" name="phone" required>

            <label class="form-label">Addresse:</label>
            <input type="text" class="form-control" name="addresse" required>

            <label class="form-label">Postal Code:</label>
            <input type="text" class="form-control" name="postalCode" required>

            <label class="form-label">Payment Type:</label>
            <select class="form-control" name="paymentType" required>
                <option value="cheque">Cheque</option>
                <option value="espece">Espèce</option>
            </select>

            <input type="submit" class="btn btn-success" name="valider" value="Valider la commande">
        </form>
    </div>
</body>
</html>