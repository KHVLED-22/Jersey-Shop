<?php
    require_once 'include/database.php';
    $id = $_GET['id'];
    // Delete related records in ligne_commande
$deleteRelated = $pdo->prepare('DELETE FROM ligne_commande WHERE id_produit = ?');
$deleteRelated->execute([$id]);

// Now, delete the product
$sqlState = $pdo->prepare('DELETE FROM produit WHERE id=?');
$supprime = $sqlState->execute([$id]);

header('location: produits.php');
