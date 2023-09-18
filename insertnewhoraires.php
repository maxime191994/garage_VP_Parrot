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
  "UPDATE horaires_ouverture
  SET heure_ouverture_matin = '08:45:00',
      heure_fermeture_matin = '12:00:00',
      heure_ouverture_aprem = '14:00:00',
      heure_fermeture_aprem = '18:00:00'
  WHERE jour_semaine IN ('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi');",
  
  "UPDATE horaires_ouverture
  SET heure_ouverture_matin = '08:45:00',
      heure_fermeture_matin = '12:00:00',
      heure_ouverture_aprem = '00:00:00', -- Fermé l'après-midi
      heure_fermeture_aprem = '00:00:00'  -- Fermé l'après-midi
  WHERE jour_semaine = 'Samedi';",
  
  
  ];
  // Exécution des migrations
foreach ($migrations as $migration) {
    try {
        $db->exec($migration);
        echo "Migration réussie : $migration\n";
    } catch (PDOException $e) {
        echo "Erreur lors de la migration : " . $e->getMessage() . "\n";
        exit(1);
    }
}

echo "Toutes les migrations ont été exécutées avec succès.\n";

// Fermeture de la connexion à la base de données
$db = null;