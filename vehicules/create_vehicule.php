<?php
require_once __DIR__ . '/../controller/VehiculesController.php';
require_once __DIR__ . "/../model/Vehicle.php";

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../auth/login.php'); // Rediriger vers la page de connexion
    exit();
}

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
                $galerieImages = []; // Vous pouvez implémenter la gestion de la galerie ici si nécessaire

                // Vérifiez si des fichiers d'image de galerie ont été téléchargés
                if (isset($_FILES["galerie_images"]) && !empty($_FILES["galerie_images"]["name"])) {
                    $galerieImages = array();

                    foreach ($_FILES["galerie_images"]["tmp_name"] as $key => $tmp_name) {
                        $galleryImageFile = $_FILES["galerie_images"]["name"][$key];
                        $galleryImageFileType = strtolower(pathinfo($galleryImageFile, PATHINFO_EXTENSION));
                        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];

                        if (in_array($galleryImageFileType, $allowedExtensions)) {
                            $targetGalleryDir = "uploads/"; // Répertoire de destination pour les images de la galerie
                            $targetGalleryFile = $targetGalleryDir . basename($galleryImageFile);

                            if (move_uploaded_file($tmp_name, $targetGalleryFile)) {
                                $galerieImages[] = $targetGalleryFile;
                            } else {
                                echo "Erreur lors du téléchargement de l'une des images de la galerie.";
                            }
                        } else {
                            echo "Seules les images au format JPG, JPEG, PNG et GIF sont autorisées dans la galerie.";
                        }
                    }
                }

                // Créez un tableau JSON pour les caractéristiques (vous pouvez le personnaliser)
                $caracteristiques = json_encode([
                    "annee" => $annee_mise_en_circulation,
                    "kilometrage" => $kilometrage,
                    "options" => $options
                ]);

                // Créez une instance de Vehicule avec les données du formulaire
                $vehicule = new Vehicle(null, $marques, $nom_modele, $annee_mise_en_circulation, $prix, $kilometrage, $description, $targetFile, $galerieImages, $caracteristiques, $options);

                // Créez une instance de VehiculesController pour ajouter le véhicule
                $vehiculesController = new VehiculesController();
                if ($vehiculesController->createVehicule($vehicule)) {
                    echo "Le véhicule a été créé avec succès.";
                } else {
                    echo "Erreur lors de la création du véhicule.";
                }
            } else {
                echo "Erreur lors du téléchargement de l'image principale.";
            }
        } else {
            echo "Seuls les fichiers au format JPG, JPEG, PNG et GIF sont autorisés.";
        }
    } else {
        echo "Veuillez sélectionner une image principale pour le véhicule.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau véhicule</title>
    <!-- Intégration des CDN Bootstrap et jQuery -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../auth/admin_dashboard.php">Tableau de bord de l'administrateur</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../employes/list_employes.php">Gérer les Employés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../services/list_services.php">Gérer les Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../horaires/list_horaires_ouverture.php">Gérer les Horaires</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../vehicules/list_vehicules.php">Gérer les Véhicules</a>
                </li>
                
            </ul>
        </div>
        <form class="form-inline" method="post">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="logout">Déconnexion</button>
        </form>
    </nav>
    
    <div class="container mt-4">
        <h1 class="mb-4">Créer un nouveau véhicule</h1>
        <form action="create_vehicule.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="marques">Marques :</label>
                <input type="text" class="form-control" name="marques" required>
            </div>
            <div class="form-group">
                <label for="nom_modele">Nom du modèle :</label>
                <input type="text" class="form-control" name="nom_modele" required>
            </div>
            <div class="form-group">
                <label for="annee_mise_en_circulation">Année de mise en circulation :</label>
                <input type="text" class="form-control" name="annee_mise_en_circulation" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix :</label>
                <input type="text" class="form-control" name="prix" required>
            </div>
            <div class="form-group">
                <label for="kilometrage">Kilométrage :</label>
                <input type="text" class="form-control" name="kilometrage" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="options">Options (séparées par des virgules) :</label>
                <input type="text" class="form-control" name="options">
            </div>
            <div class="form-group">
                <label for="image_principale">Image principale :</label>
                <input type="file" class="form-control-file" name="image_principale" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="galerie_images">Images de la galerie :</label>
                <input type="file" class="form-control-file" name="galerie_images[]" multiple accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Créer le véhicule</button>
        </form>
    </div>
    <footer class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <h6 class="text-center">Horaires d'ouverture</h6>
                    <div class="text-center">
                        <ul class="small text-center">
                            <?php
                            require_once __DIR__ . "/../controller/HorairesOuvertureController.php"; // Remplacez par le chemin réel
                            $horairesController = new HorairesOuvertureController();

                            // Appel de la méthode pour récupérer les horaires d'ouverture
                            $horairesOuverture = $horairesController->listHorairesOuverture();

                            // Parcours des horaires et affichage avec le format HH:MM
                            foreach ($horairesOuverture as $horaire) {
                                $heureOuvertureMatin = date("H:i", strtotime($horaire->getHeureOuvertureMatin()));
                                $heureFermetureMatin = date("H:i", strtotime($horaire->getHeureFermetureMatin()));
                                $heureOuvertureAprem = date("H:i", strtotime($horaire->getHeureOuvertureAprem()));
                                $heureFermetureAprem = date("H:i", strtotime($horaire->getHeureFermetureAprem()));
                                echo '<li>' . $horaire->getJourSemaine() . ': ' . $heureOuvertureMatin . ' - ' . $heureFermetureMatin . ', ' . $heureOuvertureAprem . ' - ' . $heureFermetureAprem . '</li>';
                            }
                            ?>
                            <li>Dimanche : Fermé</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <p class="small text-center">123 Rue de la République<br>31000 Toulouse</p>
                    <p class="small text-center"><a href="mailto:VPGarage@outlook.fr">VPGarage@outlook.fr</a><br><a href="tel:+1234567890">+123 456 7890</a></p>
                    <p class="small text-center">&copy; 2023 Garage V. Parrot</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

