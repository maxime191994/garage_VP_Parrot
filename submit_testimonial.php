<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Les balises meta, les liens CSS et les scripts JS nécessaires -->
</head>
<body>
    <!-- Inclure le fichier header.php -->
    <?php include('header.php'); ?>
    <?php
include('config.php');

// Récupérer les témoignages approuvés
$query = "SELECT * FROM temoignages WHERE approuve = true ORDER BY date_ajout DESC";
$stmt = $conn->query($query);
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <section id="testimonial-form" class="my-4">
        <div class="container">
            <h2>Soumettre un Témoignage</h2>
            <p>Partagez votre expérience avec nous ! Remplissez le formulaire ci-dessous pour soumettre votre témoignage.</p>

            <!-- Formulaire -->
            <form method="POST" action="process_testimonial_customer.php">
                <!-- Vos champs de formulaire ici... -->
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="commentaire">Commentaire :</label>
                    <textarea class="form-control" id="commentaire" name="commentaire" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="note">Note :</label>
                    <select class="form-control" id="note" name="note" required>
                        <option value="1">1 (Très médiocre)</option>
                        <option value="2">2 (Médiocre)</option>
                        <option value="3">3 (Moyen)</option>
                        <option value="4">4 (Bon)</option>
                        <option value="5">5 (Excellent)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
        </div>
    </section>

    <!-- Inclure le fichier footer.php -->
    <?php include('footer.php'); ?>
</body>
</html>
