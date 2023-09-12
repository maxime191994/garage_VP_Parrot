<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../model/Testimonial.php";
require_once __DIR__ . "/../controller/TestimonialsController.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $testimonial_id = isset($_POST["testimonial_id"]) ? $_POST["testimonial_id"] : null;

    // Vérifier si l'ID du témoignage est valide
    if ($testimonial_id !== null && is_numeric($testimonial_id)) {
        // Créer une instance de contrôleur de témoignages
        $testimonialsController = new TestimonialsController();

        // Récupérer le témoignage par ID
        $testimonial = $testimonialsController->getTestimonial($testimonial_id);

        // Vérifier si le témoignage existe
        if ($testimonial !== null) {
            // Récupérer et valider les autres données du formulaire
            $nom = isset($_POST["nom"]) ? $_POST["nom"] : $testimonial->getNom();
            $commentaire = isset($_POST["commentaire"]) ? $_POST["commentaire"] : $testimonial->getCommentaire();
            $note = isset($_POST["note"]) ? $_POST["note"] : $testimonial->getNote();
            $date_ajout = isset($_POST["date_ajout"]) ? $_POST["date_ajout"] : $testimonial->getDateAjout();
            $approuve = isset($_POST["approuve"]) ? 1 : 0;

            // Créer une nouvelle instance de témoignage avec les données mises à jour
            $updatedTestimonial = new Testimonial(
                $testimonial_id,
                $nom,
                $commentaire,
                $note,
                $date_ajout,
                $approuve
            );

            // Mettre à jour le témoignage dans la base de données
            if ($testimonialsController->updateTestimonial($updatedTestimonial)) {
                // Rediriger vers une page de succès ou afficher un message de réussite
                header("Location: list_testimonials.php?success=1");
                exit();
            } else {
                // Rediriger vers une page d'erreur ou afficher un message d'erreur
                header("Location: list_testimonials.php?error=1");
                exit();
            }
        } else {
            // Le témoignage avec l'ID spécifié n'existe pas, gérer cette situation en conséquence
            echo "Le témoignage avec l'ID $testimonial_id n'existe pas.";
        }
    } else {
        // L'ID du témoignage n'est pas valide, gérer cette situation en conséquence
        echo "ID de témoignage non valide.";
    }
} else {
    // Le formulaire n'a pas été soumis, gérer cette situation en conséquence
    echo "Le formulaire n'a pas été soumis.";
}
?>
