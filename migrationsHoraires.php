<?php
// Connexion à la base de données PostgreSQL en utilisant les informations de votre base de données Heroku
$dsn = "pgsql:host=ec2-44-199-168-34.compute-1.amazonaws.com;port=5432;dbname=dfas2914kcf6or";
$user = "u5ckfm7c4276jf";
$password = "pb1ddfae765cc65aac5123cae3e1cff69244d522a52dd5e6baaeac514b2ef577f";

try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données PostgreSQL réussie.\n";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage() . "\n";
    exit(1);
}

// Liste des commandes SQL de migration
$migrations = [
  "ALTER TABLE horaires_ouverture
  ADD COLUMN heure_ouverture_matin TIME,
  ADD COLUMN heure_fermeture_matin TIME,
  ADD COLUMN heure_ouverture_aprem TIME,
  ADD COLUMN heure_fermeture_aprem TIME;",
  
  "ALTER TABLE horaires_ouverture
  DROP COLUMN heure_ouverture,
  DROP COLUMN heure_fermeture;",
  
  
  ];