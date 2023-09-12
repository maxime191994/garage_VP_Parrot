<?php
require_once "../controller/HorairesOuvertureController.php";
require_once "../model/HoraireOuverture.php";

$horairesOuvertureController = new HorairesOuvertureController();

// Vérification de l'ID de l'horaire d'ouverture à éditer
if (!isset($_POST['horaire_ouverture_id']) || empty($_POST['horaire_ouverture_id'])) {
    header("Location: list_horaires_ouverture.php");
    exit;
}

// Récupération des détails de l'horaire d'ouverture
$horaireId = $_POST['horaire_ouverture_id'];
$horaire = $horairesOuvertureController->getHoraireOuverture($horaireId);

// Si l'horaire d'ouverture n'existe pas, rediriger vers la liste
if (!$horaire) {
    header("Location: list_horaires_ouverture.php");
    exit;
}

// Vérification des données du formulaire
$heure_ouverture = isset($_POST['heure_ouverture']) ? $_POST['heure_ouverture'] : $horaire->getHeureOuverture();
$heure_fermeture = isset($_POST['heure_fermeture']) ? $_POST['heure_fermeture'] : $horaire->getHeureFermeture();

// Création d'une nouvelle instance de HoraireOuverture avec les données mises à jour
$updatedHoraireOuverture = new HoraireOuverture(
    $horaireId,
    $horaire->getJourSemaine(),
    $heure_ouverture,
    $heure_fermeture
);

// Mettre à jour l'horaire d'ouverture dans la base de données
$success = $horairesOuvertureController->updateHoraireOuverture($updatedHoraireOuverture);

if ($success) {
    // Rediriger vers une page de succès ou afficher un message de réussite
    header("Location: list_horaires_ouverture.php");
    exit;
} else {
    // Afficher un message d'erreur en cas d'échec de la mise à jour
    echo "Erreur lors de la mise à jour de l'horaire d'ouverture.";
}
?>
