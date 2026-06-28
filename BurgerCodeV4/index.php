<?php
    require 'admin/database.php';
    $db = Database::connect();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicious-Hub</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="java/script.js" defer></script>
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bagel+Fat+One&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Monoton&family=Rouge+Script&family=Tagesschrift&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Monoton&family=Tagesschrift&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tagesschrift&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container-fluid p-0">
        <div class="text-center" id="header">
            <h1 class="text-logo"> <span class="glyphicon glyphicon-cutlery"></span>Delicious-<span class="code"></span><span class="glyphicon glyphicon-cutlery"></span></h1>
        </div>
        
        <!-- Navigation dynamique avec les catégories de la BDD -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs justify-content-center mt-3" id="myTab" role="tablist">
                        <?php
                        
                        $statement = $db->query('SELECT * FROM categories');
                        $categories = $statement->fetchAll();
                        $first = true;
                        
                        foreach($categories as $category) {
                            $isActive = $first ? 'active' : '';
                            $ariaSelected = $first ? 'true' : 'false';
                            $categoryName = strtoupper($category['name']); 
                            
                            echo '<li class="nav-item" role="presentation">';
                            echo '<a class="nav-link menu-tab ' . $isActive . '" id="' . $category['id'] . '-tab" data-toggle="tab" href="#category' . $category['id'] . '" role="tab" aria-controls="category' . $category['id'] . '" aria-selected="' . $ariaSelected . '">' . $categoryName . '</a>';
                            echo '</li>';
                            
                            $first = false;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <!--Slider Debut-->
        <div class="slider-container">
            <div class="slider" style="--slider-items: 6; --slider-height: 200px">
                <div class="list">
                    <div class="item"><img src="images/New/pngegg.png" alt="Menu 1"></div>
                    <div class="item"><img src="images/New/planet-orange.png" alt="Menu 2"></div>
                    <div class="item"><img src="images/New/PLAT_DE_NDOLE.png" alt="Menu 3"></div>
                    <div class="item"><img src="images/New/pngegg.png" alt="Menu 5"></div>
                    <div class="item"><img src="images/New/pngegg (2).png" alt="Menu 6"></div>
                    <div class="item"><img src="images/New/planet-frenadine-250ml.png" alt="Menu 7"></div>
                    <div class="item"><img src="images/New/pngegg.png" alt="Burger 2"></div>
                    <div class="item"><img src="images/New/pngegg.png" alt="Burger 3"></div>
                    <div class="item"><img src="images/New/pngegg.png" alt="Burger 4"></div>
                    <div class="item"><img src="images/New/pngegg.png" alt="Burger 5"></div>
                    <div class="item"><img src="images/New/pngegg.png" alt="Burger 6"></div>
                </div>
            </div>
        </div>
        <!--Slider fin-->

        <div class="tab-content" id="myTabContent">
            <?php
            // Contenu des onglets
            $first = true;
            foreach($categories as $category) {
                $isActive = $first ? 'show active' : '';
                
                echo '<div class="tab-pane fade ' . $isActive . '" id="category' . $category['id'] . '" role="tabpanel" aria-labelledby="' . $category['id'] . '-tab">';
                echo '<div class="container">';
                echo '<div class="row">';
                
                // Recup article
                $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
                $statement->execute(array($category['id']));
                
                while($item = $statement->fetch()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-img-container" class="img-fluid">';
                    echo '<img src="images/' . $item['image'] . '" class="card-img-top" class="img-fluid" alt="' . $item['name'] . '">';
                    echo '<span class="price-tag">' . number_format($item['price'], 2, '.', '') . ' Xaf</span>';
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title menu-name">' . $item['name'] . '</h5>';
                    echo '<p class="card-text">' . $item['description'] . '</p>';
                    echo '<button class="btn btn-order btn-block"  data-toggle="modal" data-target="#Modal-'. $item['id'] .'">';
                    echo '<i class="fas fa-shopping-cart"></i> COMMANDER';
                    echo '</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    echo '<div class="modal fade" id="Modal-'. $item['id'] .'" tabindex="-1" role="dialog"  aria-hidden="true">';
         echo '<div class="modal-dialog modal-dialog-centered modal-lg" role="document">';
         echo '<div class="modal-content">';
          echo '<div class="modal-header">';
         echo  '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
         echo  '<span aria-hidden="true">&times;</span>';
         echo ' </button>';
         echo ' </div>';
         echo  '<div class="modal-body">';
         echo   '<div class="row">';
         echo  ' <div class="col-sm-6">';
         echo   ' <h1><strong>Veiller remplir</strong></h1>';
         echo   ' <br>';
         echo   '<form class="form"  >';
         echo  '<div class="form-group">';
         echo  ' <label for="name">Nom:</label>';
         echo  ' <input type="text" class="form-control" id="name" name="name" placeholder="Nom" required title="veillez remplir le champs">';
         echo  '</div>';
         echo  '<div class="form-group">';
         echo  '<label for="numero">Numero de telephone:</label>';
         echo  ' <input type="text" class="form-control" id="numero" name="numero" placeholder="numero" required title="veillez remplir le champs">'; 
         echo   ' </div>';
         echo  '<div class="form-group">';
         echo  '<label for="Quartier">Quartier de residence:</label>';
         echo  ' <input type="text" class="form-control" id="Quartier" name="Quartier" placeholder="Quartier" required title="veillez remplir le champs">'; 
         echo   ' </div>';
        echo  '<div class="form-group">';
         echo  '<label for="Quantite">Quantite:</label>';
         echo  ' <select class="form-control"">';
         echo '<option selected>1</option>';
         echo '<option >2.</option>';
          echo '<option >4</option>';
           echo '<option >5</option>';
            echo '<option >6</option>'; 
                    echo '<option >7</option>';
         echo '<option >8</option>';  
             echo  ' </select>'; 
         echo   ' </div>';
         echo    '<br>';
                    
         echo   ' <div class="form-actions">';
         echo      '</div>';
        echo     '</form>';
        echo      '</div>';
         echo     '<div class="col-sm-6 site">' ;
        echo    '<div class="card-img-container">';
        echo   '<img src="images/' . $item['image'] . '" class="img-fluid" alt="' . $item['name'] . '">';
          echo '<span class="price-tag">' . number_format($item['price'], 2, '.', '') . ' €</span>';      
         echo           '</div>';
                     echo '<h5 class="card-title menu-name">' . $item['name'] . '</h5>';
                    echo '<p class="card-text">' . $item['description'] . '</p>';
             echo   '</div>';
         echo      ' </div>';
         echo     '</div>';
         echo     '<div class="modal-footer">';
         echo      ' <button class="btn btn-primary" id="valider" data-dismiss="modal"  type="close">VALIDER LA COMMANDE</button>';
         echo     '</div>';
         echo       '</div>';
         echo   '</div>';
         echo      ' </div>';
        
                
                 
           
        
                
                }
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                $first = false;
            }
            
            // Fermeture de la connexion
            Database::disconnect();
            ?>
        </div>
    </div>

    <!-- jQuery et Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
</body>
</html>
