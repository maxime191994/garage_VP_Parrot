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
            <div class="col-md-6 col-12 text-center">
                <h6 class="text-center">Horaires d'ouverture</h6>
                <div class="text-center">
                    <ul class="small text-center">
                        <?php
                        require_once __DIR__ . "/controller/HorairesOuvertureController.php";
                        $horairesController = new HorairesOuvertureController();

                        // Appel de la méthode pour récupérer les horaires d'ouverture
                        $horairesOuverture = $horairesController->listHorairesOuverture();

                        // Parcours des horaires et affichage avec le format HH:MM
                        foreach ($horairesOuverture as $horaire) {
                            $jourSemaine = $horaire->getJourSemaine();
                            $heureOuvertureMatin = date("H:i", strtotime($horaire->getHeureOuvertureMatin()));
                            $heureFermetureMatin = date("H:i", strtotime($horaire->getHeureFermetureMatin()));
                            $heureOuvertureAprem = date("H:i", strtotime($horaire->getHeureOuvertureAprem()));
                            $heureFermetureAprem = date("H:i", strtotime($horaire->getHeureFermetureAprem()));

                            // Exclure le samedi et afficher uniquement les horaires du matin
                            if ($jourSemaine !== 'Samedi') {
                                echo '<li>' . $jourSemaine . ': ' . $heureOuvertureMatin . ' - ' . $heureFermetureMatin . ', ' . $heureOuvertureAprem . ' - ' . $heureFermetureAprem . '</li>';
                            } else {
                                echo '<li>' . $jourSemaine . ': ' . $heureOuvertureMatin . ' - ' . $heureFermetureMatin . '</li>';
                            }
                        }
                        ?>
                        <li>Dimanche : Fermé</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <!-- Vos informations de contact et de droits d'auteur restent inchangées ici -->
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
