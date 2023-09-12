<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../model/Vehicle.php"; // Assurez-vous que le chemin vers le modèle de VehiculeOccasion est correct

class VehiculesController {

    // Méthode pour récupérer la liste des véhicules d'occasion
    public function listVehicules() {
        global $conn;
        $vehicules = array();

        $sql = "SELECT * FROM vehicules_occasion"; // Assurez-vous que la table vehicules_occasion existe
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                // Créez une instance de VehiculeOccasion avec les données de la base de données
                $vehicule = new Vehicle(
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
                array_push($vehicules, $vehicule);
            }
        }

        return $vehicules;
    }

    // Méthode pour récupérer un véhicule par son ID
    public function getVehicule($id) {
        global $conn;

        $sql = "SELECT * FROM vehicules_occasion WHERE id = $id"; // Assurez-vous que la table vehicules_occasion existe
        $result = $conn->query($sql);

        if ($result !== false && $result->rowCount() === 1) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $vehicule = new Vehicle(
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
            return $vehicule;
        } else {
            return null;
        }
    }

    // Méthode pour créer un véhicule
    public function createVehicule($vehicule) {
        global $conn;

        $marque = $vehicule->getMarque();
        $nom_modele = $vehicule->getNomModele();
        $annee_mise_en_circulation = $vehicule->getAnneeMiseEnCirculation();
        $prix = $vehicule->getPrix();
        $kilometrage = $vehicule->getKilometrage();
        $description = $vehicule->getDescription();
        $image_principale = $vehicule->getImagePrincipale();
        $galerie_images = json_encode($vehicule->getGalerieImages());
        $caracteristiques = json_encode($vehicule->getCaracteristiques());
        $options = implode(',', $vehicule->getOptions());

        $sql = "INSERT INTO vehicules_occasion (marques, nom_modele, annee_mise_en_circulation, prix, kilometrage, description, image_principale, galerie_images, caractéristiques, options)
                VALUES (:marque, :nom_modele, :annee_mise_en_circulation, :prix, :kilometrage, :description, :image_principale, :galerie_images, :caracteristiques, :options)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':nom_modele', $nom_modele);
        $stmt->bindParam(':annee_mise_en_circulation', $annee_mise_en_circulation);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':kilometrage', $kilometrage);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_principale', $image_principale);
        $stmt->bindParam(':galerie_images', $galerie_images);
        $stmt->bindParam(':caracteristiques', $caracteristiques);
        $stmt->bindParam(':options', $options);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour mettre à jour un véhicule
    public function updateVehicule($vehicule) {
        global $conn;

        $id = $vehicule->getId();
        $marque = $vehicule->getMarque();
        $nom_modele = $vehicule->getNomModele();
        $annee_mise_en_circulation = $vehicule->getAnneeMiseEnCirculation();
        $prix = $vehicule->getPrix();
        $kilometrage = $vehicule->getKilometrage();
        $description = $vehicule->getDescription();
        $image_principale = $vehicule->getImagePrincipale();
        $galerie_images = json_encode($vehicule->getGalerieImages());
        $caracteristiques = json_encode($vehicule->getCaracteristiques());
        $options = implode(',', $vehicule->getOptions());

        $sql = "UPDATE vehicules_occasion SET 
                marques = :marque,
                nom_modele = :nom_modele,
                annee_mise_en_circulation = :annee_mise_en_circulation,
                prix = :prix,
                kilometrage = :kilometrage,
                description = :description,
                image_principale = :image_principale,
                galerie_images = :galerie_images,
                caractéristiques = :caracteristiques,
                options = :options
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':nom_modele', $nom_modele);
        $stmt->bindParam(':annee_mise_en_circulation', $annee_mise_en_circulation);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':kilometrage', $kilometrage);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_principale', $image_principale);
        $stmt->bindParam(':galerie_images', $galerie_images);
        $stmt->bindParam(':caracteristiques', $caracteristiques);
        $stmt->bindParam(':options', $options);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour supprimer un véhicule par son ID
    public function deleteVehicule($id) {
        global $conn;

        $sql = "DELETE FROM vehicules_occasion WHERE id = $id"; // Assurez-vous que la table vehicules_occasion existe

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getPaginatedVehicules($results_per_page, $offset) {
      global $conn;
      $vehicules = array();
  
      $sql = "SELECT * FROM vehicules_occasion OFFSET :offset LIMIT :results_per_page";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
      $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
      $stmt->execute();
  
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $vehicule = new Vehicle(
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
          array_push($vehicules, $vehicule);
      }
  
      return $vehicules;
  }

    // Méthode pour récupérer le nombre total de véhicules d'occasion
    public function getTotalVehicules() {
        global $conn;

        $sql = "SELECT COUNT(*) FROM vehicules_occasion";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    // Méthode pour ajouter une photo principale et une galerie de photos à un véhicule
    public function addPhotosToVehicule($vehiculeId, $imagePrincipale, $galerieImages) {
        global $conn;

        // Mettez à jour le véhicule avec les nouvelles images
        $sql = "UPDATE vehicules_occasion SET 
                image_principale = :image_principale,
                galerie_images = :galerie_images
                WHERE id = :vehiculeId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':vehiculeId', $vehiculeId);
        $stmt->bindParam(':image_principale', $imagePrincipale);
        $stmt->bindParam(':galerie_images', json_encode($galerieImages));

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // ... Autres méthodes pour la gestion des véhicules d'occasion ...

}
?>
