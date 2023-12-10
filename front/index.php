<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head_front.php' ?>
    <title>Accueil</title>
    <style>
        .category-name.selected {
    color: red !important;
}


.search-container {
        text-align: center;
        padding: 15px; /* Adjust the padding as needed */
    }
        .category-icon {
            width: 30px;
            height: 30px;
            margin-right: 5px; /* Adjust the margin as needed */
        }

        .product-image {
            width: 150px; /* Set the desired width for product images */
            height: 190px; /* Set the desired height for product images */
            object-fit: cover; /* Ensure images maintain their aspect ratio */
            margin: 0 auto; /* Center the image horizontally */
            display: block; /* Ensure block-level display to apply margin */
        }

        /* Add a new class for the selected category */
        .selected-category {
            background-color: #e6f7ff; /* Set your desired background color */
        }
    </style>
</head>
<body>
    <?php include '../include/nav_front.php' ?>
    <!-- recherche -->









    <!-- ... (your existing HTML code) ... -->

<div class="container mt-3 search-container">
    <form class="form-inline my-2 my-lg-0">
        <div class="input-group">
            <input class="form-control" type="search" id="searchInput" placeholder="Rechercher des produits..." aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </div>
        </div>
    </form>
    <div id="searchResults" class="mt-3 search-results"></div>
</div>

<!-- ... (rest of your HTML code) ... -->

<style>
    #searchResults {
        position: absolute;
        width: 100%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        background-color: #fff;
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        display: none; /* Hide initially */
    }

    .search-container {
        position: relative;
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 2000;
    }

    .search-result-item {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s;
    }

    .search-result-item a {
        color: #333;
        text-decoration: none;
    }

    .search-result-item:hover {
        background-color: #f5f5f5;
    }

    .search-result-item img {
        max-width: 50px;
        height: auto;
        margin-right: 10px;
    }

    .search-result-item .result-details {
        display: flex;
        align-items: center;
    }

    .search-result-item .result-details p {
        margin: 0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('searchResults');

    searchInput.addEventListener('input', function () {
        let query = this.value.trim();

        if (query.length === 0) {
            // Clear results container if search query is empty
            resultsContainer.innerHTML = '';
            resultsContainer.style.display = 'none'; // Hide the results container
            return;
        }

        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'search_dropdown.php?query=' + query, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    resultsContainer.innerHTML = '';
                    let results = JSON.parse(xhr.responseText);

                    console.log("Results length:", results.length); // Log the length of results

                    if (results.length > 0) {
                        // Add the search-results class to the main container
                        resultsContainer.classList.add('search-results');

                        // Add each product as a result
                        results.forEach(function (product) {
                            let resultItem = document.createElement('div');
                            resultItem.classList.add('search-result-item');
                            resultItem.innerHTML = '<a href="produit.php?id=' + product.id + '">' + product.libelle + '</a>';
                            resultsContainer.appendChild(resultItem);
                        });

                        resultsContainer.style.display = 'block'; // Show the results container
                    } else {
                        resultsContainer.innerHTML = 'Aucun résultat trouvé';
                        resultsContainer.style.display = 'none'; // Hide the results container
                    }
                } else {
                    console.error("Une erreur s'est produite. Status:", xhr.status);
                }
            }
        };
        xhr.send();
    });

    // Close the results container when clicking outside of it
    document.addEventListener('click', function (event) {
        if (!resultsContainer.contains(event.target)) {
            resultsContainer.style.display = 'none';
        }
    });
});


</script>













    <div class="container py-2">
        <?php
        require_once '../include/database.php';
        $categoryId = $_GET['id'] ?? NULL;
        $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_OBJ);

        if (!is_null($categoryId)) {
            $sqlState = $pdo->prepare("SELECT * FROM produit WHERE id_categorie=? ORDER BY date_creation DESC");
            $sqlState->execute([$categoryId]);
            $produits = $sqlState->fetchAll(PDO::FETCH_OBJ);
        } else {
            $produits = $pdo->query("SELECT * FROM produit ORDER BY date_creation DESC")->fetchAll(PDO::FETCH_OBJ);
        }

        $activeClasses = 'active bg-success rounded border-success';
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-group list-group-flush position-sticky sticky-top">
                        <h4 class=" mt-4"><i class="fa fa-light fa-list"></i> Liste des catégories</h4>
                        <li class="list-group-item <?= $categoryId == NULL ? $activeClasses : '' ?>">
                            <a class="btn btn-default w-100" href="./">
                                <i class="fa fa-solid fa-border-all"></i> Voir tous les produits
                            </a>
                        </li>
                        <?php
foreach ($categories as $categorie) {
    $active = $categoryId === $categorie->id ? $activeClasses . ' selected-category' : '';
    ?>
    <li class="list-group-item <?= $active ?>">
        <a class="btn btn-default w-100" href="index.php?id=<?php echo $categorie->id ?>">
            <img src="../assets/favicon/<?php echo $categorie->icone; ?>" alt="<?php echo $categorie->libelle; ?>" class="category-icon">
            <span class="category-name <?php echo $categoryId === $categorie->id ? 'selected' : '' ?>"><?php echo $categorie->libelle; ?></span>
        </a>
    </li>
<?php
}
?>


                    </ul>
                </div>
                <div class="col mt-4">
                    <div class="row">
                        <?php
                        foreach ($produits as $produit) {
                            $idProduit = $produit->id;
                            ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <?php if (!empty($produit->discount)): ?>
                                        <span class="badge rounded-pill text-bg-warning w-25 position-absolute m-2" style="right:0"> - <?= $produit->discount ?> <i class="fa fa-percent"></i></span>
                                    <?php endif; ?>
                                    <img class="card-img-top product-image" src="../upload/produit/<?= $produit->image ?>" alt="Product Image">
                                    <div class="card-body">
                                        <a href="produit.php?id=<?php echo $idProduit ?>" class="btn stretched-link"></a>
                                        <h5 class="card-title"><?= $produit->libelle ?></h5>
                                        <p class="card-text"><?= $produit->description ?></p>
                                        <p class="card-text"><small class="text-muted">Ajouté le : <?= date_format(date_create($produit->date_creation), 'Y/m/d') ?></small></p>
                                    </div>
                                    <div class="card-footer bg-white" style="z-index: 10">
                                        <?php if (!empty($produit->discount)): ?>
                                            <div class="h5"><span class="badge rounded-pill text-bg-danger"><strike> <?= $produit->prix ?></strike> <i class="fa fa-solid fa-dollar"></i></span></div>
                                            <div class="h5"><span class="badge rounded-pill text-bg-success">Solde : <?= calculerRemise($produit->prix, $produit->discount) ?> <i class="fa fa-solid fa-dollar"></i></span></div>
                                        <?php else: ?>
                                            <div class="h5"><span class="badge rounded-pill text-bg-success"><?= $produit->prix ?> <i class="fa fa-solid fa-dollar"></i></span></div>
                                        <?php endif; ?>
                                        <?php include '../include/front/counter.php' ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        if (empty($produits)) {
                            ?>
                            <div class="alert alert-info" role="alert">
                                Pas de produits pour l'instant
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
