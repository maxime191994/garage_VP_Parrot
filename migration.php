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
    // Table pour les administrateurs
    "CREATE TABLE administrateurs (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        prenom VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        mot_de_passe VARCHAR(255) NOT NULL
    );",

    // Table pour les employés
    "CREATE TABLE employes (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        prenom VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        mot_de_passe VARCHAR(255) NOT NULL
    );",

    // Table pour les services
    "CREATE TABLE services (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        description TEXT
    );",

    // Table pour les horaires d'ouverture
    "CREATE TABLE horaires_ouverture (
        id SERIAL PRIMARY KEY,
        jour_semaine VARCHAR(20) NOT NULL,
        heure_ouverture TIME NOT NULL,
        heure_fermeture TIME NOT NULL
    );",

    // Table pour les véhicules d'occasion
    "CREATE TABLE vehicules_occasion (
        id SERIAL PRIMARY KEY,
        marques VARCHAR(255) NOT NULL,
        nom_modele VARCHAR(255) NOT NULL,
        annee_mise_en_circulation INT NOT NULL,
        prix DECIMAL(10, 2) NOT NULL,
        kilometrage INT NOT NULL,
        description TEXT,
        image_principale VARCHAR(255),
        galerie_images JSON,
        caractéristiques JSON,
        options TEXT
    );",

    // Table pour les témoignages des clients
    "CREATE TABLE temoignages (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        commentaire TEXT NOT NULL,
        note INT NOT NULL CHECK (note >= 1 AND note <= 5),
        date_ajout TIMESTAMP DEFAULT NOW(),
        approuve BOOLEAN DEFAULT FALSE
    );",

    // Insertion de données dans la table "services"
    "INSERT INTO services (nom, description)
    VALUES
        ('Réparation de Carrosserie', 'Nous offrons des services de réparation de carrosserie professionnels pour redonner à votre voiture son aspect d''origine.'),
        ('Entretien Mécanique', 'Confiez-nous l''entretien mécanique de votre véhicule. Nous sommes spécialisés dans la réparation de moteurs, freins, et plus encore.'),
        ('Vente de Véhicules d''Occasion', 'Découvrez notre sélection de véhicules d''occasion de qualité. Trouvez la voiture qui correspond à vos besoins.');",

    // Insertion de données dans la table "horaires_ouverture"
    "INSERT INTO horaires_ouverture (jour_semaine, heure_ouverture, heure_fermeture)
    VALUES
        ('Lundi', '08:30:00', '18:30:00'),
        ('Mardi', '08:30:00', '18:30:00'),
        ('Mercredi', '08:30:00', '18:30:00'),
        ('Jeudi', '08:30:00', '18:30:00'),
        ('Vendredi', '08:30:00', '18:30:00'),
        ('Samedi', '08:30:00', '12:00:00');",

    // Modification de la colonne "prix" pour changer son type en INT
    "ALTER TABLE vehicules_occasion
    ALTER COLUMN prix TYPE INT
    USING prix::integer;",

"INSERT INTO administrateurs (nom, prenom, email, mot_de_passe)
VALUES ('Parrot', 'Vincent', 'VPGarage@outlook.fr', '$2y$10$8pxMTSUAMXy9AdilfnCBm.XS5mjIwPKnTdE3ICY7PIrwlbd01/6AC');",


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
?>
