<?php
require_once __DIR__ . "/config.php"; // Assurez-vous que le chemin vers votre fichier de configuration est correct
require_once __DIR__ . "/model/Vehicle.php"; // Assurez-vous que le chemin vers le modèle de véhicule est correct

// Récupérez les données des filtres depuis la requête POST
$kilometrageMin = isset($_POST['kilometrageMin']) ? $_POST['kilometrageMin'] : '';
$kilometrageMax = isset($_POST['kilometrageMax']) ? $_POST['kilometrageMax'] : '';
$anneeMin = isset($_POST['anneeMin']) ? $_POST['anneeMin'] : '';
$anneeMax = isset($_POST['anneeMax']) ? $_POST['anneeMax'] : '';
$prixMin = isset($_POST['prixMin']) ? $_POST['prixMin'] : '';
$prixMax = isset($_POST['prixMax']) ? $_POST['prixMax'] : '';

$sql = "SELECT * FROM vehicules_occasion WHERE 1 = 1";

if (!empty($kilometrageMin)) {
    $sql .= " AND kilometrage >= $kilometrageMin";
}

if (!empty($kilometrageMax)) {
    $sql .= " AND kilometrage <= $kilometrageMax";
}

if (!empty($anneeMin)) {
    $sql .= " AND annee_mise_en_circulation >= $anneeMin";
}

if (!empty($anneeMax)) {
    $sql .= " AND annee_mise_en_circulation <= $anneeMax";
}

if (!empty($prixMin)) {
    $sql .= " AND prix >= $prixMin";
}

if (!empty($prixMax)) {
    $sql .= " AND prix <= $prixMax";
}


// Exécutez la requête SQL pour récupérer les véhicules filtrés
$result = $conn->query($sql);

if ($result) {
    $vehicles = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Créez une instance de Vehicle avec les données de la base de données
        $vehicle = new Vehicle(
            $row["id"],
            $row["marques"],
            $row["nom_modele"],
            $row["annee_mise_en_circulation"],
            $row["prix"],
            $row["kilometrage"],
            $row["description"],
            $row["image_principale"],
            json_decode($row["galerie_images"], true),
            json_decode($row["caractéristiques"], true),
            explode(',', $row["options"])
            // Ajoutez d'autres propriétés ici si nécessaire
        );
        array_push($vehicles, $vehicle);
    }

    // Générez le HTML pour la liste des véhicules filtrés
    foreach ($vehicles as $vehicle) {
      $imageFilename = $vehicle->getImagePrincipale();
      $relativePath = "vehicules";
      $imagePath = $relativePath . '/' . $imageFilename;
  
      echo '<div class="col-lg-4 col-md-6 col-sm-12">';
      echo '<div class="card" style="position: relative;">'; // Ajoutez position: relative; pour que la pastille soit positionnée par rapport à la carte
      echo '<div style="position: absolute; top: 10px; left: 10px; background-color: #404040; color: #fff; padding: 5px; border-radius: 5px;">' . $vehicle->getPrix() . ' €</div>'; // Pastille avec le prix
      echo '<img class="card-img-top" src="' . $imagePath . '" alt="' . $vehicle->getMarque() . ' ' . $vehicle->getNomModele() . '">';
      echo '<div class="card-body">';
      echo '<h5 class="card-title"><strong>' . $vehicle->getMarque() . ' ' . $vehicle->getNomModele() . '</strong></h5>';
      echo '<p class="card-text small">Année: ' . $vehicle->getAnneeMiseEnCirculation() . '</p>';
      echo '<p class="card-text small">Kilométrage: ' . $vehicle->getKilometrage() . ' km</p>';
      
      echo '<hr>';
      
      echo '<p class="card-text"><strong style="font-size: 16px;">Prix: ' . $vehicle->getPrix() . ' €</strong></p>';
      echo '<div class="text-center"><a href="vehicle_details.php?id=' . $vehicle->getId() . '" class="btn btn-primary">Détails</a></div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
  }
  
  
} else {
    // Gérez les erreurs si la requête SQL échoue
    echo 'Une erreur s\'est produite lors de la récupération des véhicules.';
}
?>
