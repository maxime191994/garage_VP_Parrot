<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des véhicules</title>
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

<?php
require_once __DIR__ . "/../controller/VehiculesController.php";
require_once __DIR__ . "/../model/Vehicle.php";

$vehiculesController = new VehiculesController();

// Paramètres de pagination
$results_per_page = 10; // Nombre de résultats par page

// Récupérer le numéro de page actuel depuis l'URL
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = intval($_GET['page']);
} else {
    $current_page = 1; // Page par défaut
}

// Calculer l'offset pour la requête SQL
$offset = ($current_page - 1) * $results_per_page;

// Récupérer la liste des véhicules paginée
$vehicules = $vehiculesController->getPaginatedVehicules($results_per_page, $offset);

// Récupérer le nombre total de véhicules (pour la pagination)
$total_vehicules = $vehiculesController->getTotalVehicules();

// Calculer le nombre total de pages
$total_pages = ceil($total_vehicules / $results_per_page);
// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../auth/login.php'); // Rediriger vers la page de connexion
    exit();
}
?>

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

    <div class="container mt-4">
        <h1 class="mb-4">Liste des véhicules</h1>
        <a href="create_vehicule.php" class="btn btn-primary">Ajouter un véhicule</a>
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marques</th>
                    <th>Nom du modèle</th>
                    <th>Année de mise en circulation</th>
                    <th>Prix</th>
                    <th>Kilométrage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicules as $vehicule): ?>
                    <tr>
                        <td><?php echo $vehicule->getId(); ?></td>
                        <td><?php echo $vehicule->getMarque(); ?></td>
                        <td><?php echo $vehicule->getNomModele(); ?></td>
                        <td><?php echo $vehicule->getAnneeMiseEnCirculation(); ?></td>
                        <td><?php echo $vehicule->getPrix(); ?> €</td>
                        <td><?php echo $vehicule->getKilometrage(); ?></td>
                        <td>
                            <a href="edit_vehicule.php?id=<?php echo $vehicule->getId(); ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="delete_vehicule.php?id=<?php echo $vehicule->getId(); ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        <!-- Affichage des liens de pagination -->
        <div class="pagination justify-content-center">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                        <a class="page-link" href="list_vehicules.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
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
