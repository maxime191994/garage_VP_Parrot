<?php
// Configuration de la base de données PostgreSQL
$db_host = "localhost"; // Nom d'hôte de la base de données (généralement "localhost")
$db_name = "Garage_Parrot"; // Nom de la base de données
$db_user = "postgres"; // Nom d'utilisateur de la base de données (par défaut)
$db_password = "A44342598"; // Mot de passe de la base de données

// Connexion à la base de données
try {
    $conn = new PDO("pgsql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
