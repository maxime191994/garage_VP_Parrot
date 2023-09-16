<?php
require_once __DIR__ . "/../controller/VehiculesController.php";
require_once __DIR__ . "/../model/Vehicle.php";

$vehiculesController = new VehiculesController();

// Vérification de l'ID du véhicule à éditer
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_vehicules.php");
    exit;
}

// Récupération des détails du véhicule
$vehiculeId = $_GET['id'];
$vehicule = $vehiculesController->getVehicule($vehiculeId);

// Si le véhicule n'existe pas, rediriger vers la liste
if (!$vehicule) {
    header("Location: list_vehicules.php");
    exit;
}
// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../auth/login.php'); // Rediriger vers la page de connexion
    exit();
}

// Traiter la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $marques = $_POST["marques"];
    $nom_modele = $_POST["nom_modele"];
    $annee_mise_en_circulation = $_POST["annee_mise_en_circulation"];
    $prix = $_POST["prix"];
    $kilometrage = $_POST["kilometrage"];
    $description = $_POST["description"];
    $options = isset($_POST["options"]) ? $_POST["options"] : [];

    // Ajout du champ pour changer l'image principale
    $image_principale = $_FILES["image_principale"];
    if (!empty($image_principale["name"])) {
        $targetDir = "uploads/"; // Répertoire de destination pour l'image principale
        $imagePrincipaleTargetFile = $targetDir . basename($image_principale["name"]);
        $imagePrincipaleFileType = strtolower(pathinfo($imagePrincipaleTargetFile, PATHINFO_EXTENSION));

        // Vérifiez si le fichier est une image et déplacez-le vers le répertoire de destination
        if (in_array($imagePrincipaleFileType, ["jpg", "jpeg", "png", "gif"]) &&
            move_uploaded_file($image_principale["tmp_name"], $imagePrincipaleTargetFile)) {
            $vehicule->setImagePrincipale($imagePrincipaleTargetFile);
        }
    }

    // Vérifiez si des fichiers de galerie ont été téléchargés
    $galerieImages = [];
    if (!empty($_FILES["galerie_images"]["name"][0])) {
        $targetDir = "uploads/"; // Répertoire de destination pour les images de la galerie
        $totalImages = count($_FILES["galerie_images"]["name"]);
        for ($i = 0; $i < $totalImages; $i++) {
            $galerieTargetFile = $targetDir . basename($_FILES["galerie_images"]["name"][$i]);
            $galerieImageFileType = strtolower(pathinfo($galerieTargetFile, PATHINFO_EXTENSION));

            // Vérifiez si le fichier est une image et déplacez-le vers le répertoire de destination
            if (in_array($galerieImageFileType, ["jpg", "jpeg", "png", "gif"]) &&
                move_uploaded_file($_FILES["galerie_images"]["tmp_name"][$i], $galerieTargetFile)) {
                $galerieImages[] = $galerieTargetFile;
            }
        }
    }

    // Mettez à jour l'objet véhicule avec les nouvelles images de la galerie
    $vehicule->setGalerieImages($galerieImages);

    // Mettez à jour les autres propriétés du véhicule
    $vehicule->setMarque($marques);
    $vehicule->setNomModele($nom_modele);
    $vehicule->setAnneeMiseEnCirculation($annee_mise_en_circulation);
    $vehicule->setPrix($prix);
    $vehicule->setKilometrage($kilometrage);
    $vehicule->setDescription($description);
    $vehicule->setOptions($options);

   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un véhicule</title>
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
        <h1 class="mb-4">Éditer un véhicule</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="vehicule_id" value="<?php echo $vehicule->getId(); ?>">
            <div class="mb-3">
                <label for="marques" class="form-label">Marques</label>
                <input type="text" class="form-control" id="marques" name="marques" value="<?php echo $vehicule->getMarque(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nom_modele" class="form-label">Nom du modèle</label>
                <input type="text" class="form-control" id="nom_modele" name="nom_modele" value="<?php echo $vehicule->getNomModele(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="annee_mise_en_circulation" class="form-label">Année de mise en circulation</label>
                <input type="text" class="form-control" id="annee_mise_en_circulation" name="annee_mise_en_circulation" value="<?php echo $vehicule->getAnneeMiseEnCirculation(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="text" class="form-control" id="prix" name="prix" value="<?php echo $vehicule->getPrix(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="kilometrage" class="form-label">Kilométrage</label>
                <input type="text" class="form-control" id="kilometrage" name="kilometrage" value="<?php echo $vehicule->getKilometrage(); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $vehicule->getDescription(); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="options" class="form-label">Options (séparées par des virgules)</label>
                <input type="text" class="form-control" id="options" name="options" value="<?php echo implode(', ', $vehicule->getOptions()); ?>">
            </div>
            
            <!-- Champ pour changer l'image principale -->
            <div class="mb-3">
                <label for="image_principale" class="form-label">Image principale (format : jpg, jpeg, png, gif)</label>
                <input type="file" class="form-control-file" id="image_principale" name="image_principale" accept="image/*">
            </div>

            <!-- Champ pour télécharger des images de la galerie -->
            <div class="mb-3">
                <label for="galerie_images" class="form-label">Images de la galerie (sélectionnez plusieurs fichiers)</label>
                <input type="file" class="form-control-file" id="galerie_images" name="galerie_images[]" accept="image/*" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
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
                                $heureOuverture = date("H:i", strtotime($horaire->getHeureOuverture()));
                                $heureFermeture = date("H:i", strtotime($horaire->getHeureFermeture()));
                                echo '<li>' . $horaire->getJourSemaine() . ': ' . $heureOuverture . ' - ' . $heureFermeture . '</li>';
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
