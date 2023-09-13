<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des véhicules</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
    
    <!-- Inclure la bibliothèque noUiSlider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>

    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h1 class="mt-4">Liste des véhicules</h1>

        <!-- Filtres -->
        <div class="row mt-4">
            <div class="col-md-4">
                <label for="kilometrage">Kilométrage</label>
                <div id="kilometrageSlider"></div>
                <input type="hidden" id="kilometrageMin" name="kilometrageMin" value="0">
                <input type="hidden" id="kilometrageMax" name="kilometrageMax" value="100000">
                <div id="kilometrageValues" class="slider-values">0 km - 100000 km</div>
            </div>

            <div class="col-md-4">
                <label for="annee">Année</label>
                <div id="anneeSlider"></div>
                <input type="hidden" id="anneeMin" name="anneeMin" value="1950">
                <input type="hidden" id="anneeMax" name="anneeMax" value="2023">
                <div id="anneeValues" class="slider-values">1950 - 2023</div>
            </div>

            <div class="col-md-4">
                <label for="prix">Prix</label>
                <div id="prixSlider"></div>
                <input type="hidden" id="prixMin" name="prixMin" value="0">
                <input type="hidden" id="prixMax" name="prixMax" value="100000">
                <div id="prixValues" class="slider-values">0 € - 100000 €</div>
            </div>
        </div>

        <!-- Liste des véhicules -->
        <div class="vehicle-list mt-4 row">
            <!-- Cette div sera mise à jour par JavaScript -->
        </div>
    </div>

    <!-- Scripts JavaScript pour les filtres et l'affichage des véhicules -->
    <script src="/js/scripts.js"></script>

    <script>
        // Fonction pour mettre à jour la liste des véhicules en fonction des filtres
        function updateVehicleList() {
            var kilometrageMin = document.getElementById('kilometrageMin').value;
            var kilometrageMax = document.getElementById('kilometrageMax').value;
            var anneeMin = document.getElementById('anneeMin').value;
            var anneeMax = document.getElementById('anneeMax').value;
            var prixMin = document.getElementById('prixMin').value;
            var prixMax = document.getElementById('prixMax').value;

            // Créez des chaînes de texte pour afficher les valeurs avec "km" et "€"
            var kilometrageText = kilometrageMin + ' km - ' + kilometrageMax + ' km';
            var prixText = prixMin + ' € - ' + prixMax + ' €';

            // Mettez à jour les éléments HTML correspondants
            $('#kilometrageValues').text(kilometrageText);
            $('#prixValues').text(prixText);

            // Envoyer une requête AJAX à get_filtered_vehicles.php
            $.ajax({
                url: 'get_filtered_vehicles.php',
                method: 'POST',
                data: {
                    kilometrageMin: kilometrageMin,
                    kilometrageMax: kilometrageMax,
                    anneeMin: anneeMin,
                    anneeMax: anneeMax,
                    prixMin: prixMin,
                    prixMax: prixMax
                },
                success: function (data) {
    // Mettre à jour la section de la liste des véhicules avec les données reçues
    $('.vehicle-list').html(data);
    
    // Ajoutez des classes Bootstrap aux cartes pour les aligner sur la même ligne
    $('.vehicle-card').addClass('col-md-4 mb-4'); // Vous pouvez ajuster la classe col-md-4 selon vos besoins
},
                error: function () {
                    alert('Une erreur s\'est produite lors de la récupération des véhicules filtrés.');
                }
            });
        }

        // Attachez un événement aux éléments de filtre pour déclencher la mise à jour lorsque les valeurs changent
        $('#kilometrageMin, #kilometrageMax, #anneeMin, #anneeMax, #prixMin, #prixMax').on('input', function () {
            updateVehicleList();
        });

        // Chargez la liste initiale des véhicules lors du chargement de la page
        updateVehicleList();
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
