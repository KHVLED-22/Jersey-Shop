<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('location: ../connexion.php');
    exit();
}

// Récupère l'ID de l'utilisateur connecté
$idUtilisateur = $_SESSION['utilisateur']['id'];

// Vérifie si l'action "vider" a été soumise
if (isset($_POST['vider'])) {
    // Vide le panier de l'utilisateur
    $_SESSION['panier'][$idUtilisateur] = [];

    // Redirige l'utilisateur vers la page du panier
    header('location: panier.php');
    exit();
}

// Redirige l'utilisateur vers la page du panier si l'accès direct à ce fichier est tenté
header('location: panier.php');
exit();
?>