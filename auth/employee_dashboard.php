<?php
session_start();

// Vérifiez si l'utilisateur est connecté en tant qu'employé
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'employee') {
    header('Location: login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié en tant qu'employé
    exit();
}

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord de l'employé</title>
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
        <a class="navbar-brand" href="../auth/employee_dashboard.php">Tableau de bord de l'employé - <?php echo $nom . ' ' . $prenom; ?></a>
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

    <!-- Contenu du tableau de bord -->
    <div class="container mt-4">
        <h1>Bienvenue, <?php echo $nom . ' ' . $prenom; ?></h1>
        <!-- Affichez le nom et le prénom ici aussi -->

               
        <!-- Carte pour gérer les témoignages des clients -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Gérer les Témoignages des Clients</h5>
                <p class="card-text">Cliquez sur les liens ci-dessous pour gérer les témoignages :</p>
                <a href="../temoignages/create_testimonial.php" class="btn btn-primary">Créer un Témoignage</a>
                <a href="../temoignages/edit_testimonial.php" class="btn btn-info">Approuver un Témoignages</a>
                <a href="../temoignages/delete_testimonial.php" class="btn btn-danger">Supprimer un Témoignages</a>
                <a href="../temoignages/list_testimonials.php" class="btn btn-secondary">Liste des Témoignages</a>
            </div>
        </div>

        <!-- Carte pour gérer les véhicules -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Gérer les Véhicules</h5>
                <p class="card-text">Cliquez sur les liens ci-dessous pour gérer les véhicules :</p>
                <a href="../vehicules/create_vehicule_user.php" class="btn btn-primary">Créer un Véhicule</a>
                <a href="../vehicules/edit_vehicule_user.php" class="btn btn-info">Modifier un Véhicule</a>
                <a href="../vehicules/delete_vehicule_user.php" class="btn btn-danger">Supprimer un Véhicule</a>
                <a href="../vehicules/list_vehicules_user.php" class="btn btn-secondary">Liste des Véhicules</a>
            </div>
        </div>

        <!-- Ajoutez d'autres cartes pour d'autres fonctionnalités selon vos besoins -->

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
    <!-- Inclure Bootstrap JS (à la fin du corps pour de meilleures performances) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
