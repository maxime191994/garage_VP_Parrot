<?php
session_start();

// Vérifiez si l'utilisateur est connecté en tant qu'employé
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'employee') {
    header('Location: ../auth/login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié en tant qu'employé
    exit();
}

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../auth/login.php'); // Rediriger vers la page de connexion
    exit();
}

// Inclure le fichier de configuration PDO
include('../config.php');

// Récupérez le nom et le prénom de l'employé connecté depuis la base de données
$user_id = $_SESSION['user_id'];
$sql = "SELECT nom, prenom FROM employes WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$nom = $row['nom'];
$prenom = $row['prenom'];

// Code HTML de la page du tableau de bord de l'employé
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un véhicule</title>
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
        <a class="navbar-brand" href="/../auth/employee_dashboard.php">Tableau de bord de l'employé - <?php echo $nom . ' ' . $prenom; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                
                <li class="nav-item">
                    <a class="nav-link" href="../temoignages/list_testimonials.php">Gérer les Témoignages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../vehicules/list_vehicules_user.php">Gérer les Véhicules</a>
                </li>
            </ul>
        </div>
        <form class="form-inline ml-auto" method="post">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="logout">Déconnexion</button>
        </form>
    </nav>
    
    <div class="container mt-4">
        <?php
        require_once __DIR__ . "/../controller/VehiculesController.php";

        // Vérification de l'ID du véhicule à supprimer
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: list_vehicules_user.php"); // Rediriger vers la liste des véhicules si l'ID est manquant
            exit;
        }

        $vehiculesController = new VehiculesController();

        // Récupération des détails du véhicule
        $vehiculeId = $_GET['id'];
        $vehicule = $vehiculesController->getVehicule($vehiculeId);

        // Si le véhicule n'existe pas, rediriger vers la liste
        if (!$vehicule) {
            header("Location: list_vehicules_user.php");
            exit;
        }

        // Traitement de la suppression du véhicule
        if (isset($_POST['delete'])) {
            if ($vehiculesController->deleteVehicule($vehiculeId)) {
                header("Location: list_vehicules_user.php");
                exit;
            }
        }
        ?>
        <h1>Supprimer un véhicule</h1>
        <p>Êtes-vous sûr de vouloir supprimer le véhicule <?php echo $vehicule->getMarque(); ?> <?php echo $vehicule->getNomModele(); ?> ?</p>
        <form action="" method="POST">
            <button type="submit" name="delete" class="btn btn-danger mb-4">Supprimer</button>
            <a href="list_vehicules_user.php" class="btn btn-secondary mb-4">Annuler</a>
        </form>
        <form action="list_vehicules_user.php" method="GET">
            <button type="submit" class="btn btn-success mb-4">Retourner à la liste des véhicules</button>
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
