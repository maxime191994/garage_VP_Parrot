<?php
require_once __DIR__ . "/../controller/VehiculesController.php";
require_once __DIR__ . "/../model/Vehicle.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $marques = $_POST["marques"];
    $nom_modele = $_POST["nom_modele"];
    $annee_mise_en_circulation = $_POST["annee_mise_en_circulation"];
    $prix = $_POST["prix"];
    $kilometrage = $_POST["kilometrage"];
    $description = $_POST["description"];
    $options = isset($_POST["options"]) ? $_POST["options"] : [];

    // Vérifiez si un fichier image principale a été téléchargé
    if (isset($_FILES["image_principale"]) && $_FILES["image_principale"]["error"] === 0) {
        $targetDir = "uploads/"; // Répertoire de destination pour les images
        $targetFile = $targetDir . basename($_FILES["image_principale"]["name"]);

        // Vérifiez si le fichier est une image
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowedExtensions)) {
            // Déplacez le fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($_FILES["image_principale"]["tmp_name"], $targetFile)) {
                // Le fichier a été téléchargé avec succès
                $galerieImages = []; // Initialisez un tableau pour stocker les images de la galerie

                // Vérifiez si des fichiers de galerie ont été téléchargés
                if (!empty($_FILES["galerie_images"]["name"])) {
                    $totalImages = count($_FILES["galerie_images"]["name"]);
                    for ($i = 0; $i < $totalImages; $i++) {
                        $galerieTargetFile = $targetDir . basename($_FILES["galerie_images"]["name"][$i]);
                        $galerieImageFileType = strtolower(pathinfo($galerieTargetFile, PATHINFO_EXTENSION));

                        // Vérifiez si le fichier est une image et déplacez-le vers le répertoire de destination
                        if (in_array($galerieImageFileType, $allowedExtensions) &&
                            move_uploaded_file($_FILES["galerie_images"]["tmp_name"][$i], $galerieTargetFile)) {
                            $galerieImages[] = $galerieTargetFile;
                        }
                    }
                }

                // Créez une instance de Véhicule avec les données du formulaire
                $vehicule = new Vehicle(null, $marques, $nom_modele, $annee_mise_en_circulation, $prix, $kilometrage, $description, $targetFile, $galerieImages, [], $options);

                // Créez une instance de VehiculesController pour ajouter le véhicule
                $vehiculesController = new VehiculesController();
                if ($vehiculesController->createVehicule($vehicule)) {
                    echo "<div class='container'>";
                    echo "<h2>Véhicule créé avec succès.</h2>";
                    echo "</div>";
                } else {
                    echo "Erreur lors de la création du véhicule.";
                }
            } else {
                echo "Erreur lors du téléchargement de l'image principale.";
            }
        } else {
            echo "Seuls les fichiers au format JPG, JPEG, PNG et GIF sont autorisés pour l'image principale.";
        }
    } else {
        echo "Veuillez sélectionner une image principale pour le véhicule.";
    }
}
?>
