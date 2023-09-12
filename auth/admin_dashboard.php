<?php
session_start();

// Vérifiez si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php'); // Rediriger vers la page de connexion
    exit();
}

// Inclure le fichier de configuration PDO
include('../config.php');

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php'); // Rediriger vers la page de connexion
    exit();
}

// Code HTML de la page d'administration
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord de l'administrateur</title>
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
<!-- Barre de navigation -->
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

    <!-- Contenu du tableau de bord -->
    <div class="container mt-4">
        <h1>Bienvenue, Administrateur de VP Garage</h1>

        <!-- Carte pour gérer les employés -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Gérer les Employés</h5>
                <p class="card-text">Cliquez sur les liens ci-dessous pour gérer les employés :</p>
                <a href="../employes/create_employee.php" class="btn btn-primary">Créer un Employé</a>
                <a href="../employes/edit_employee.php" class="btn btn-info">Modifier un Employé</a>
                <a href="../employes/delete_employee.php" class="btn btn-danger">Supprimer un Employé</a>
                <a href="../employes/list_employes.php" class="btn btn-secondary">Liste des Employés</a>
            </div>
        </div>

        <!-- Carte pour gérer les services -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Gérer les Services</h5>
                <p class="card-text">Cliquez sur les liens ci-dessous pour gérer les services :</p>
                <a href="../services/create_service.php" class="btn btn-primary">Créer un Service</a>
                <a href="../services/edit_service.php" class="btn btn-info">Modifier un Service</a>
                <a href="../services/delete_service.php" class="btn btn-danger">Supprimer un Service</a>
                <a href="../services/list_services.php" class="btn btn-secondary">Liste des Services</a>
            </div>
        </div>

        <!-- Carte pour gérer les véhicules -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Gérer les Véhicules</h5>
                <p class="card-text">Cliquez sur les liens ci-dessous pour gérer les véhicules :</p>
                <a href="../vehicules/create_vehicule.php" class="btn btn-primary">Créer un Véhicule</a>
                <a href="../vehicules/edit_vehicule.php" class="btn btn-info">Modifier un Véhicule</a>
                <a href="../vehicules/delete_vehicule.php" class="btn btn-danger">Supprimer un Véhicule</a>
                <a href="../vehicules/list_vehicules.php" class="btn btn-secondary">Liste des Véhicules</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Gérer les horaires</h5>
                <p class="card-text">Cliquez sur les liens ci-dessous pour gérer les horaires :</p>
                <a href="../horaires/edit_horairesOuverture.php" class="btn btn-info">Modifier les horaires</a>
                <a href="../horaires/list_horaires_ouverture.php" class="btn btn-secondary">Liste des horaires</a>
            </div>
        </div>

    </div>
    <footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <h6 class="text-center">   Horaires d'ouverture</h6>
                <div class="text-center"> <!-- Ajout de cette div pour centrer le contenu des horaires -->
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
    <!-- Inclure Bootstrap JS (à la fin du corps pour de meilleures performances) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>
