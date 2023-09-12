<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Garage V. Parrot</title>
    <!-- Intégration des CDN Bootstrap et jQuery -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <h6 class="text-center">   Horaires d'ouverture</h6>
                <div class="text-center"> <!-- Ajout de cette div pour centrer le contenu des horaires -->
                    <ul class="small text-center">
                        <?php
                        require_once __DIR__ . "../controller/HorairesOuvertureController.php"; // Remplacez par le chemin réel
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




<!-- Scripts JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
