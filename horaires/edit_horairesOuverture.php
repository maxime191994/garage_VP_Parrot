<?php
require_once "../controller/HorairesOuvertureController.php";

$horairesOuvertureController = new HorairesOuvertureController();

// Vérification de l'ID de l'horaire d'ouverture à éditer
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_horaires_ouverture.php");
    exit;
}

// Récupération des détails de l'horaire d'ouverture
$horaireOuvertureId = $_GET['id'];
$horaireOuverture = $horairesOuvertureController->getHoraireOuverture($horaireOuvertureId);

// Si l'horaire d'ouverture n'existe pas, rediriger vers la liste
if (!$horaireOuverture) {
    header("Location: list_horaires_ouverture.php");
    exit;
}

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../auth/login.php'); // Rediriger vers la page de connexion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer un horaire d'ouverture</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
    <!-- Lien vers la bibliothèque Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Lien vers la bibliothèque Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Référence au fichier styles.css -->
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
        <h1 class="mb-4">Éditer un horaire d'ouverture</h1>
        <form action="process_edit_horaireOuverture.php" method="POST">
            <input type="hidden" name="horaire_ouverture_id" value="<?php echo $horaireOuverture->getId(); ?>">
            <div class="mb-3">
                <label for="jour_semaine" class="form-label">Jour de la semaine</label>
                <input type="text" class="form-control" id="jour_semaine" name="jour_semaine" value="<?php echo $horaireOuverture->getJourSemaine(); ?>" readonly>
            </div>
            <div class="mb-3">
            <label for="heure_ouverture" class="form-label">Heure d'ouverture matin</label>
                <input type="text" class="form-control flatpickr-input" id="heure_ouverture_matin" name="heure_ouverture_matin" value="<?php echo $horaireOuverture->getHeureOuvertureMatin(); ?>" required data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
            </div>
            <div class="mb-3">
            <label for="heure_fermeture" class="form-label">Heure de fermeture matin</label>
                <input type="text" class="form-control flatpickr-input" id="heure_fermeture_matin" name="heure_fermeture_matin" value="<?php echo $horaireOuverture->getHeureFermetureMatin(); ?>" required data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
            </div>
            <div class="mb-3">
            <label for="heure_ouverture" class="form-label">Heure d'ouverture après-midi</label>
                <input type="text" class="form-control flatpickr-input" id="heure_ouverture_aprem" name="heure_ouverture_aprem" value="<?php echo $horaireOuverture->getHeureOuvertureAprem(); ?>" required data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
            </div>

            <div class="mb-3">
            <label for="heure_fermeture" class="form-label">Heure de fermeture après-midi</label>
                <input type="text" class="form-control flatpickr-input" id="heure_fermeture_aprem" name="heure_fermeture_aprem" value="<?php echo $horaireOuverture->getHeureFermetureAprem(); ?>" required data-enable-time="true" data-no-calendar="true" data-date-format="H:i">
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
                            // Appel de la méthode pour récupérer les horaires d'ouverture
                            $horairesOuverture = $horairesOuvertureController->listHorairesOuverture();

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" 
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
    flatpickr(".flatpickr-input", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });
</script>
</body>
</html>
