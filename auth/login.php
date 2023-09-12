<?php
require_once "../model/Employee.php"; // Assurez-vous du chemin correct
require_once "../model/Administrator.php"; // Assurez-vous du chemin correct
require_once __DIR__ . "/../config.php";

class ControllerLogin {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        // Préparez la requête avec des paramètres liés en utilisant le nom correct de la colonne ("email")
        $sql = "SELECT * FROM administrateurs WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
    
        // Exécutez la requête
        $stmt->execute();
    
        // Vérifiez le nombre de lignes retournées
        if ($stmt->rowCount() === 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $row["mot_de_passe"];
            
            // Utilisez password_verify pour vérifier le mot de passe
            if (password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_type"] = "admin"; // Ajoutez cette ligne pour définir le type d'utilisateur
                header("Location: admin_dashboard.php");
                return true;
            }
        }
        
        // Si aucune correspondance n'est trouvée dans la table des administrateurs, recherchez dans la table des employés
        $sql = "SELECT * FROM employes WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
    
        // Exécutez la requête pour les employés
        $stmt->execute();
    
        if ($stmt->rowCount() === 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $row["mot_de_passe"];
            
            // Utilisez password_verify pour vérifier le mot de passe
            if (password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_type"] = "employee"; // Ajoutez cette ligne pour définir le type d'utilisateur
                header("Location: employee_dashboard.php");
                return true;
            }
        }
        
        return false; // Identifiants invalides
    }
}

$controllerLogin = new ControllerLogin($conn); // Passer la connexion à l'instanciation du contrôleur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($controllerLogin->login($email, $password)) {
        // La connexion a réussi, l'utilisateur a été redirigé vers le tableau de bord approprié
        // Aucun affichage ici car l'utilisateur est redirigé
    } else {
        // La connexion a échoué, vous pouvez afficher un message d'erreur ici
        echo "Identifiants invalides. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Ajout du logo -->
            <a class="navbar-brand custom-logo" href="../index.php">
                <img src="../images/LogoVP.png" alt="Logo Garage V. Parrot">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../services.php">Nos Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../vehicles.php">Véhicules d'Occasion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contact.php">Contact</a>
                    </li>
                    <!-- Bouton de connexion pour tous les utilisateurs -->
                    <li class="nav-item">
                        <a class="nav-link" href="auth/login.php">Connexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Connexion</h2>
                <form action="" method="post"> <!-- Supprimé l'attribut "action" pour que le formulaire se soumette vers lui-même -->
                    <div class="form-group">
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe :</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center monlogoengrand">
    <img src="../images/LogoVP.png" alt="Logo VP" width="300">
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
