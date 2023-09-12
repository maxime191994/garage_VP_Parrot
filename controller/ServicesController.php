<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../model/Service.php"; // Assurez-vous que le chemin vers le modèle de Service est correct

class ServicesController {

    // Méthode pour récupérer la liste des services
    public function listServices() {
        global $conn;
        $services = array();

        $sql = "SELECT * FROM services"; // Assurez-vous que la table services existe
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                // Créez une instance de Service avec les données de la base de données
                $service = new Service(
                    $row["id"],
                    $row["nom"],
                    $row["description"]
                    // Ajoutez d'autres propriétés ici si nécessaire
                );
                array_push($services, $service);
            }
        }

        return $services;
    }

    // Méthode pour récupérer un service par son ID
    public function getService($id) {
        global $conn;

        $sql = "SELECT * FROM services WHERE id = $id"; // Assurez-vous que la table services existe
        $result = $conn->query($sql);

        if ($result !== false && $result->rowCount() === 1) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $service = new Service(
                $row["id"],
                $row["nom"],
                $row["description"]
                // Ajoutez d'autres propriétés ici si nécessaire
            );
            return $service;
        } else {
            return null;
        }
    }

    // Méthode pour créer un service
    public function createService($service) {
        global $conn;

        $nom = $service->getNom();
        $description = $service->getDescription();

        $sql = "INSERT INTO services (nom, description)
                VALUES (:nom, :description)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour mettre à jour un service
    public function updateService($service) {
        global $conn;

        $id = $service->getId();
        $nom = $service->getNom();
        $description = $service->getDescription();

        $sql = "UPDATE services SET 
                nom = :nom,
                description = :description
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour supprimer un service par son ID
    public function deleteService($id) {
        global $conn;

        $sql = "DELETE FROM services WHERE id = $id"; // Assurez-vous que la table services existe

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getPaginatedServices($results_per_page, $offset) {
      global $conn;
      $services = array();
  
      $sql = "SELECT * FROM services OFFSET :offset LIMIT :results_per_page";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
      $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
      $stmt->execute();
  
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $service = new Service(
              $row["id"],
              $row["nom"],
              $row["description"]
              // Ajoutez d'autres propriétés ici si nécessaire
          );
          array_push($services, $service);
      }
  
      return $services;
  }
  

    // Méthode pour récupérer le nombre total de services
    public function getTotalServices() {
        global $conn;

        $sql = "SELECT COUNT(*) FROM services";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    // ... Autres méthodes pour la gestion des services ...

}
?>
