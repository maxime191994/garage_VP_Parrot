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
    <title>Liste des témoignages</title>

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
        require_once __DIR__ . "/../controller/TestimonialsController.php"; // Assurez-vous que le chemin vers le contrôleur des témoignages est correct

        $testimonialsController = new TestimonialsController();

        // Récupération de la liste des témoignages
        $testimonials = $testimonialsController->listTestimonials();
        ?>

        <h1 class="mb-4">Liste des témoignages</h1>
        <a href="create_testimonial.php" class="btn btn-primary">Ajouter un témoignage</a>
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Commentaire</th>
                    <th>Note</th>
                    <th>Date d'ajout</th>
                    <th>Approuvé</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $testimonial): ?>
                    <tr>
                        <td><?php echo $testimonial->getId(); ?></td>
                        <td><?php echo $testimonial->getNom(); ?></td>
                        <td><?php echo $testimonial->getCommentaire(); ?></td>
                        <td><?php echo $testimonial->getNote(); ?></td>
                        <td><?php echo date("d/m/Y - H:i", strtotime($testimonial->getDateAjout())); ?></td>
                        <td>
                            <?php
                            if ($testimonial->isApprouve()) {
                                echo '<span class="text-success">Oui</span>';
                            } else {
                                echo '<span class="text-danger">Non</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit_testimonial.php?id=<?php echo $testimonial->getId(); ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="delete_testimonial.php?id=<?php echo $testimonial->getId(); ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
