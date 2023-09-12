<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de véhicule</title>

    <!-- Lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Lien vers la police Google Fonts (Ubuntu) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">

    <!-- Lien vers votre fichier CSS personnalisé (styles.css) -->
    <link rel="stylesheet" href="../css/styles.css">
    
    <!-- Lien vers les scripts JavaScript Bootstrap (jQuery, Popper.js, Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    require_once __DIR__ . '/../controller/VehiculesController.php';
    require_once __DIR__ . '/../model/Vehicle.php';

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer l'ID du véhicule depuis le formulaire
        $vehicule_id = isset($_POST['vehicule_id']) ? $_POST['vehicule_id'] : null;

        // Vérifier si l'ID est valide
        if ($vehicule_id !== null && is_numeric($vehicule_id)) {
            // Créer une instance de VehiculesController
            $vehiculesController = new VehiculesController();

            // Récupérer le véhicule à partir de la base de données
            $vehicule = $vehiculesController->getVehicule($vehicule_id);

            // Vérifier si le véhicule existe
            if ($vehicule !== null) {
                // Récupérer et vérifier les autres données du formulaire
                $marques = isset($_POST['marques']) ? $_POST['marques'] : $vehicule->getMarque();
                $nom_modele = isset($_POST['nom_modele']) ? $_POST['nom_modele'] : $vehicule->getNomModele();
                $annee_mise_en_circulation = isset($_POST['annee_mise_en_circulation']) ? $_POST['annee_mise_en_circulation'] : $vehicule->getAnneeMiseEnCirculation();
                $prix = isset($_POST['prix']) ? $_POST['prix'] : $vehicule->getPrix();
                $kilometrage = isset($_POST['kilometrage']) ? $_POST['kilometrage'] : $vehicule->getKilometrage();
                $description = isset($_POST['description']) ? $_POST['description'] : $vehicule->getDescription();
                $options = isset($_POST['options']) ? $_POST['options'] : $vehicule->getOptions();

                // Gérer les images de la galerie
                $galerieImages = $vehicule->getGalerieImages();

                if (!empty($_FILES['galerie_images']['name'][0])) {
                    $targetDir = 'uploads/';
                    foreach ($_FILES['galerie_images']['tmp_name'] as $key => $tmp_name) {
                        $tmp_file = $_FILES['galerie_images']['tmp_name'][$key];
                        $targetFile = $targetDir . $_FILES['galerie_images']['name'][$key];
                        move_uploaded_file($tmp_file, $targetFile);
                        $galerieImages[] = $targetFile;
                    }
                }

                // Créer une nouvelle instance de Vehicle avec les données mises à jour
                $updatedVehicle = new Vehicle(
                    $vehicule_id,
                    $marques,
                    $nom_modele,
                    $annee_mise_en_circulation,
                    $prix,
                    $kilometrage,
                    $description,
                    $vehicule->getImagePrincipale(),
                    $galerieImages,
                    $vehicule->getCaracteristiques(),
                    $options
                );

                // Mettre à jour le véhicule dans la base de données
                $success = $vehiculesController->updateVehicule($updatedVehicle);

                if ($success) {
                    // Afficher un message de succès et un bouton pour revenir à la page précédente
                    echo "<div class='container'>";
                    echo "<h2>Véhicule mis à jour avec succès.</h2>";
                    echo "</div>";
                } else {
                    // Afficher un message d'erreur
                    echo "Erreur lors de la mise à jour du véhicule.";
                }
            } else {
                // Le véhicule n'existe pas, gérer cette situation en conséquence
                echo "Le véhicule avec l'ID $vehicule_id n'existe pas.";
            }
        } else {
            // L'ID du véhicule n'est pas valide, gérer cette situation en conséquence
            echo "ID de véhicule non valide.";
        }
    } else {
        // Le formulaire n'a pas été soumis, gérer cette situation en conséquence
        echo "Le formulaire n'a pas été soumis.";
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" 
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
