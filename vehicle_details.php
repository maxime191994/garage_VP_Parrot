<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/model/Vehicle.php";
require_once __DIR__ . "/controller/VehiculesController.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du véhicule</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-4">
        <?php
        if (isset($_GET['id'])) {
            $vehicleId = $_GET['id'];

            $vehiculesController = new VehiculesController();
            $vehicle = $vehiculesController->getVehicule($vehicleId);

            if ($vehicle) {
                $imageFilename = $vehicle->getImagePrincipale();
                $relativePath = "vehicules";
                $imagePath = $relativePath . '/' . $imageFilename;

                echo '<h1>Détails du véhicule</h1>';
                echo '<div class="row">';
                echo '    <div class="col-md-6">';

                if (file_exists($imagePath)) {
                    echo '        <img class="card-img-top" src="' . $imagePath . '" alt="' . $vehicle->getMarque() . ' ' . $vehicle->getNomModele() . '">';
                } else {
                    echo '        <img class="card-img-top" src="placeholder_image.jpg" alt="Image non disponible">';
                }

                echo '    </div>';
                echo '    <div class="col-md-6">';
                echo '        <div class="card">';
                echo '            <div class="card-body">';
                echo '                <h5 class="card-title"><strong>Annonce: ' . $vehicle->getId() . ' - ' . $vehicle->getMarque() . ' ' . $vehicle->getNomModele() . '</strong></h5>';
                echo '                <p class="card-text">Année: ' . $vehicle->getAnneeMiseEnCirculation() . '</p>';
                echo '                <p class="card-text">Kilométrage: ' . $vehicle->getKilometrage() . ' km</p>';
                echo '                <p class="card-text"><strong>Prix: ' . $vehicle->getPrix() . ' €</strong></p>';
                echo '                <p class="card-text">Description: ' . $vehicle->getDescription() . '</p>';
                echo '                <p class="card-text">Options: ' . implode(', ', $vehicle->getOptions()) . ' </p>';
                // Ajoutez le bouton "Retour à la liste"
                echo '                <a href="vehicles.php" class="btn btn-primary">Retour à la liste</a>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';

                $galerieImages = $vehicle->getGalerieImages();
                if (!empty($galerieImages)) {
                    echo '<div class="row mt-4">';
                    echo '    <div class="col-md-12">';
                    echo '        <h2>Galerie d\'images</h2>';
                    echo '    </div>';

                    foreach ($galerieImages as $index => $image) {
                        $galerieImagePath = $relativePath . '/' . $image;

                        if (file_exists($galerieImagePath)) {
                            echo '    <div class="col-md-3">';
                            echo '        <img src="' . $galerieImagePath . '" class="img-fluid mb-3" alt="Image ' . ($index + 1) . '">';
                            echo '    </div>';
                        }
                    }

                    echo '</div>';
                }

                // Ajoutez le formulaire de contact ici, sous la galerie d'images
                echo '        <h2 class="mt-4">Contacter le vendeur</h2>';
                echo '    <form method="post" action="contact.php">';
                echo '        <input type="hidden" name="sujet" value="Annonce: '. $vehicle->getId() . ' - '  . $vehicle->getMarque() . ' ' . $vehicle->getNomModele() . '">';
                echo '        <div class="form-group">';
                echo '            <label for="nom">Nom :</label>';
                echo '            <input type="text" class="form-control" id="nom" name="nom" required>';
                echo '        </div>';
                echo '        <div class="form-group">';
                echo '            <label for="prenom">Prénom :</label>';
                echo '            <input type="text" class="form-control" id="prenom" name="prenom" required>';
                echo '        </div>';
                echo '        <div class="form-group">';
                echo '            <label for="adresse_mail">Adresse e-mail :</label>';
                echo '            <input type="email" class="form-control" id="adresse_mail" name="adresse_mail" required>';
                echo '        </div>';
                echo '        <div class="form-group">';
                echo '            <label for="numero_telephone">Numéro de téléphone :</label>';
                echo '            <input type="tel" class="form-control" id="numero_telephone" name="numero_telephone">';
                echo '        </div>';
                echo '        <div class="form-group">';
                echo '            <label for="message">Message :</label>';
                echo '            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>';
                echo '        </div>';
                echo '        <button type="submit" class="btn btn-primary">Envoyer</button>';
                echo '    </form>';
                // Fin du formulaire
            } else {
                echo 'Véhicule non trouvé.';
            }
        } else {
            echo 'ID du véhicule non spécifié.';
        }
        ?>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
