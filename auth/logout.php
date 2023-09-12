<?php
// logout.php
session_start();
require_once "../config.php"; // Assurez-vous que le chemin est correct ici

// Détruire la session et rediriger vers la page de connexion
session_destroy();
header("Location: ../index.php"); // Redirige vers la page de connexion
exit();
?>
