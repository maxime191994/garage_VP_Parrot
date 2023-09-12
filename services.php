<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - Garage V. Parrot</title>
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
<body>
    <!-- Inclusion du fichier header.php -->
    <?php include('header.php'); ?>

    <section id="services" class="my-4">
    <div class="container">
        <h1 class="mb-4">Nos Services</h1>
        <p>Voici les services que nous proposons :</p>

        <div class="row">
            <?php
            require_once('config.php'); // Assurez-vous d'utiliser "require_once" pour inclure le fichier de configuration

            try {
                // Récupérez les données depuis la table "services"
                $query = "SELECT * FROM services";
                $stmt = $conn->query($query);
                $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Parcourez les résultats et affichez chaque service dans une carte
                foreach ($services as $service) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card my-2">'; // Ajout de la classe "my-2" pour une marge verticale plus grande
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $service['nom'] . '</h5>';
                    echo '<p class="card-text">' . $service['description'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo "Erreur de base de données : " . $e->getMessage();
            }
            ?>
        </div>
    </div>
</section>


    <!-- Inclure Bootstrap JS (à la fin du corps pour de meilleures performances) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" 
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Inclusion du fichier footer.php -->
    <?php include('footer.php'); ?>
</body>
</html>
