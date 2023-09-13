<?php
// Configuration de la base de données PostgreSQL
$db_host = "ec2-44-199-168-34.compute-1.amazonaws.com"; // Nom d'hôte de la base de données (généralement "localhost")
$db_name = "dfas2914kcf6or"; // Nom de la base de données
$db_user = "u5ckfm7c4276jf"; // Nom d'utilisateur de la base de données (par défaut)
$db_password = "pb1ddfae765cc65aac5123cae3e1cff69244d522a52dd5e6baaeac514b2ef577f"; // Mot de passe de la base de données

// Connexion à la base de données
try {
    $conn = new PDO("pgsql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

define('SENDGRID_API_KEY', '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');

?>

