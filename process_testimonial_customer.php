<?php
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/model/Testimonial.php";
require_once __DIR__ . "/controller/TestimonialsController.php";
require_once __DIR__ . "/process_testimonial_customer.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $commentaire = $_POST["commentaire"];
    $note = $_POST["note"];
    $dateAjout = date("Y-m-d"); // Date d'ajout actuelle, vous pouvez la personnaliser si nécessaire
    $approuve = isset($_POST["approuve"]) ? 1 : 0; // Vérifier si le témoignage est approuvé

    // Créer un nouvel objet Témoignage
    $testimonial = new Testimonial(
        null,
        $nom,
        $commentaire,
        $note,
        $dateAjout,
        $approuve
    );

    // Instancier le contrôleur des témoignages
    $testimonialsController = new TestimonialsController();

    // Créer le témoignage et gérer le résultat
    if ($testimonialsController->createTestimonial($testimonial)) {
        // Rediriger vers la liste des témoignages avec un message de succès
        header("Location: index.php?success=1");
        exit();
    } else {
        // Rediriger vers la liste des témoignages avec un message d'erreur
        header("Location: index.php?error=1");
        exit();
    }
}
?>
