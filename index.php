<!DOCTYPE html>
<html lang="fr">
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Inclusion du fichier header.php -->
    <?php include('header.php'); ?>

    <section id="hero" class="text-center margedehero">
        <h1>Bienvenue au Garage V. Parrot</h1>
        <p>Depuis 2 ans, nous proposons des services de réparation automobile de qualité à Toulouse.</p>
        <a href="services.php" class="btn btn-primary btn-lg">Découvrir nos services</a>
    </section>
    <div class="container">
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
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">' . $service['nom'] . '</h4>';
                echo '<a href="services.php" class="btn btn-primary">En savoir plus</a>';
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


    <section id="about" class="my-4">
    <div class="container">
        <div class="row">
            <!-- Carte pour "À propos de nous" -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">À propos de nous</h2>
                        <p class="card-text">Le Garage V. Parrot, dirigé par Vincent Parrot depuis 2021, offre 
                            une gamme complète de services, allant de la réparation de carrosserie et
                             de mécanique automobile à la vente de véhicules d'occasion. Nous sommes
                              dédiés à la satisfaction de nos clients, mettant à votre disposition 
                              notre expertise et notre passion pour l'automobile.</p>
                    </div>
                </div>
            </div>

            <!-- Carte pour "Contactez-nous" -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Contactez-nous</h2>
                        <p class="card-text">Pour toute question ou demande d'information, n'hésitez pas à nous contacter.</p>
                        <a href="contact.php" class="btn btn-primary">Nous Contacter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include('config.php');

// Récupérer les témoignages approuvés
$query = "SELECT * FROM temoignages WHERE approuve = true ORDER BY date_ajout DESC";
$stmt = $conn->query($query);
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
  
    <!-- Carrousel des témoignages -->
    <section id="testimonials-carousel" class="my-4 py-5">
        <div class="container">
            <h2>Témoignages de nos Clients</h2>

           <!-- Carrousel Bootstrap des 3 derniers témoignages -->
<div id="recentTestimonialCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicateurs -->
    <ol class="carousel-indicators">
        <?php
        $totalTestimonials = count($testimonials);
        $maxVisibleTestimonials = 3; // Nombre maximum de témoignages à afficher dans le carrousel
        for ($i = 0; $i < min($totalTestimonials, $maxVisibleTestimonials); $i++) :
        ?>
            <li data-bs-target="#recentTestimonialCarousel" data-bs-slide-to="<?php echo $i; ?>" <?php if ($i === 0) echo 'class="active"'; ?>></li>
        <?php endfor; ?>
    </ol>

    <!-- Contenu du carrousel -->
    <div class="carousel-inner">
        <?php
        for ($i = 0; $i < min($totalTestimonials, $maxVisibleTestimonials); $i++) :
            $testimonial = $testimonials[$i];
        ?>
            <div class="carousel-item <?php if ($i === 0) echo 'active'; ?>">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo $testimonial['nom']; ?></h5>
                        <p class="card-text text-center"><em>"<?php echo $testimonial['commentaire']; ?>"</em></p>
                        <p class="text-center">
                         <?php
                             // Récupérer la note du témoignage
                             $note = $testimonial['note'];

                            // Afficher les étoiles en fonction de la note
                            for ($j = 1; $j <= $note; $j++) {
                            echo '<i class="fas fa-star" style="color: yellow;"></i>';
                                }
                         ?>
                        </p>
                    </div>
                </div>
            </div>
            
        <?php endfor; ?>
        
    </div>

    <!-- Contrôles -->
    <a class="carousel-control-prev" href="#recentTestimonialCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </a>
    <a class="carousel-control-next" href="#recentTestimonialCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </a>
</div>
<!-- Bouton pour aller sur la page de soumission de témoignage -->
<div class="text-center">
    <div class="d-flex justify-content-center">
        <a href="submit_testimonial.php" class="btn btn-primary btn-lg">Soumettre un Témoignage</a>
    </div>
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
