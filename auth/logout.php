<?php
// logout.php
session_start();
require_once "../config.php"; 

// Détruire la session et rediriger vers la page de connexion
session_destroy();
header("Location: ../index.php"); // Redirige vers la page de connexion
exit();
?>
