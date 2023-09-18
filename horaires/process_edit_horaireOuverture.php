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
$heure_ouverture_matin = isset($_POST['heure_ouverture_matin']) ? $_POST['heure_ouverture_matin'] : $horaire->getHeureOuvertureMatin();
$heure_fermeture_matin = isset($_POST['heure_fermeture_matin']) ? $_POST['heure_fermeture_matin'] : $horaire->getHeureFermetureMatin();
$heure_ouverture_aprem = isset($_POST['heure_ouverture_aprem']) ? $_POST['heure_ouverture_aprem'] : $horaire->getHeureOuvertureAprem();
$heure_fermeture_aprem = isset($_POST['heure_fermeture_aprem']) ? $_POST['heure_fermeture_aprem'] : $horaire->getHeureFermetureAprem();

// Création d'une nouvelle instance de HoraireOuverture avec les données mises à jour
$updatedHoraireOuverture = new HoraireOuverture(
    $horaireId,
    $horaire->getJourSemaine(),
    $heure_ouverture_matin,
    $heure_fermeture_matin,
    $heure_ouverture_aprem,
    $heure_fermeture_aprem
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
