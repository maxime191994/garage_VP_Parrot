Installation pour une execution en local 

-- Création d'un administrateur avec un mot de passe hasher

<?php
$motDePasse = "monmotdepasse"; // Mot de passe en clair

// Utilisez password_hash pour générer le hachage du mot de passe
$motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);

echo "Mot de passe haché : " . $motDePasseHache;
?>

UTILISATION DE VS CODE ET POSTGRESQL

1- Dans un premier temps, connectez-vous à PostgreSQL (pgAdmin4) et créez une base de données 
   avec le nom de votre choix. Je suggère "Garage_Parrot".

2- Une fois que la base de données est créée, copiez tout le contenu du fichier "Requetes_SQL.txt" 
   et ouvrez un éditeur de requêtes dans PostgreSQL (pgAdmin4) en effectuant un clic droit.

3- Collez le contenu du fichier "Requetes_SQL.txt" dans l'éditeur et exécutez le script.

   Note : Vous devriez avoir les tables créées.

4- Assurez-vous que tous les codes et dossiers sont correctement téléchargés et placés dans un 
   dossier local nommé "Garage_Parrot". Si vous utilisez Wamp, ce dossier doit être situé dans le répertoire "www".

5- Assurez-vous de modifier le fichier "config.php" afin que les informations de la base de données correspondent à votre configuration.
$db_host = "localhost";
$db_name = "Nom de la base de données"; 
$db_user = "Nom d'utilisateur de la base de données";
$db_password = "Mot de passe de la base de données";

6- Vérifiez que le serveur local, tel que Wamp ou Xamp, est en cours d'exécution. Si c'est le cas, 
   vous devriez pouvoir exécuter le site en local en utilisant l'adresse suivante : 
   http://localhost/Garage_Parrot/index.php

   Note : Seul un administrateur, des services et les horaires sont créés. Vous pourrez ainsi créer 
          un ou des employés, des véhicules à mettre en vente, etc... Pour ce faire il vous suffit de
          vous connecter avec les identifiants de l'administrateur
          
          Je fourni les identifiants dans le cadre d'une évaluation. 

          VPGarage@outlook.fr
          azerty123456
