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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un témoignage</title>

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
        require_once __DIR__ . "/../controller/TestimonialsController.php"; 

        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: list_testimonials.php");
            exit;
        }

        $testimonialsController = new TestimonialsController();

        $testimonialId = $_GET['id'];
        $testimonial = $testimonialsController->getTestimonial($testimonialId);

        if (!$testimonial) {
            header("Location: list_testimonials.php");
            exit;
        }

        $id = $testimonial->getId();
        $nom = $testimonial->getNom();
        $commentaire = $testimonial->getCommentaire();
        $note = $testimonial->getNote();
        $date_ajout = $testimonial->getDateAjout();
        $approuve = $testimonial->isApprouve();

        if (isset($_POST['update'])) {
            $nouveauNom = $_POST['nom'];
            $nouveauCommentaire = $_POST['commentaire'];
            $nouvelleNote = $_POST['note'];
            $nouvelleDateAjout = $_POST['date_ajout'];
            $nouvelleApprobation = isset($_POST['approuve']) ? 1 : 0;

            $nouveauTemoignage = new Testimonial(
                $id,
                $nouveauNom,
                $nouveauCommentaire,
                $nouvelleNote,
                $nouvelleDateAjout,
                $nouvelleApprobation
            );

            if ($testimonialsController->updateTestimonial($nouveauTemoignage)) {
                header("Location: list_testimonials.php");
                exit;
            } else {
                echo "Erreur lors de la mise à jour du témoignage.";
            }
        }
        ?>
        <h1 class= "mb-4">Éditer un témoignage</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" required>
            </div>
            <div class="mb-3">
                <label for="commentaire" class="form-label">Commentaire</label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="4" required><?php echo $commentaire; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <input type="number" class="form-control" id="note" name="note" value="<?php echo $note; ?>" readonly>
            </div>
            <div class="mb-3">
    <label for="date_ajout" class="form-label">Date d'ajout</label>
    <?php
    // Convertir la date d'ajout au format souhaité
    $dateAjoutFormattee = date("d/m/Y - H:i", strtotime($date_ajout));
    ?>
    <input type="text" class="form-control" id="date_ajout" name="date_ajout" value="<?php echo $dateAjoutFormattee; ?>" readonly>
</div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="approuve" name="approuve" <?php echo $approuve ? 'checked' : ''; ?>>
                <label class="form-check-label" for="approuve">Approuvé</label>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
            <a href="list_testimonials.php" class="btn btn-secondary">Annuler</a>
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
