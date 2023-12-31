<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des employés</title>

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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/../auth/admin_dashboard.php">Tableau de bord de l'administrateur</a>
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
        <?php
        require_once __DIR__ . "/../controller/EmployesController.php"; // Assurez-vous que le chemin vers le contrôleur des employés est correct

        // Vérification de l'ID de l'employé à supprimer
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: list_employes.php");
            exit;
        }

        $employeesController = new EmployeesController();

        // Récupération des détails de l'employé
        $employeeId = $_GET['id'];
        $employee = $employeesController->getEmployee($employeeId);

        // Si l'employé n'existe pas, rediriger vers la liste
        if (!$employee) {
            header("Location: list_employes.php");
            exit;
        }

        // Traitement de la suppression de l'employé
        if (isset($_POST['delete'])) {
            if ($employeesController->deleteEmployee($employeeId)) {
                header("Location: list_employes.php");
                exit;
            }
        }


// Gérer la déconnexion
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: ../auth/login.php'); // Rediriger vers la page de connexion
  exit();
}
        ?>
        <h1 class= "mb-4">Supprimer un employé</h1>
        <p>Êtes-vous sûr de vouloir supprimer l'employé <?php echo $employee->getNom(); ?> ?</p>
        <form action="" method="POST">
            <button type="submit" name="delete" class="btn btn-danger mb-4">Supprimer</button>
            <a href="list_employes.php" class="btn btn-secondary mb-4">Annuler</a>
        </form>
        <form action="list_employes.php" method="GET">
            <button type="submit" class="btn btn-success mb-4">Retourner à la liste des employés</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" 
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
