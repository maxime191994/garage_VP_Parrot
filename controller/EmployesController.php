<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../model/Employee.php"; // Assurez-vous que le chemin vers le modèle Employee est correct

class EmployeesController {

    // Méthode pour récupérer la liste des employés
    public function listEmployees() {
        global $conn;
        $employees = array();

        $sql = "SELECT * FROM employes"; // Assurez-vous que la table employes existe
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                // Créez une instance d'Employee avec les données de la base de données
                $employee = new Employee(
                    $row["id"],
                    $row["nom"],
                    $row["prenom"],
                    $row["email"],
                    $row["mot_de_passe"]
                    // Ajoutez d'autres propriétés ici si nécessaire
                );
                array_push($employees, $employee);
            }
        }

        return $employees;
    }

    // Méthode pour récupérer un employé par son ID
    public function getEmployee($id) {
        global $conn;

        $sql = "SELECT * FROM employes WHERE id = $id"; // Assurez-vous que la table employes existe
        $result = $conn->query($sql);

        if ($result !== false && $result->rowCount() === 1) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $employee = new Employee(
                $row["id"],
                $row["nom"],
                $row["prenom"],
                $row["email"],
                $row["mot_de_passe"]
                // Ajoutez d'autres propriétés ici si nécessaire
            );
            return $employee;
        } else {
            return null;
        }
    }

    // Méthode pour créer un employé
    public function createEmployee($employee) {
        global $conn;

        $nom = $employee->getNom();
        $prenom = $employee->getPrenom();
        $email = $employee->getEmail();
        $mot_de_passe = $employee->getMotDePasse();

        $sql = "INSERT INTO employes (nom, prenom, email, mot_de_passe)
                VALUES (:nom, :prenom, :email, :mot_de_passe)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour mettre à jour un employé
    public function updateEmployee($employee) {
        global $conn;

        $id = $employee->getId();
        $nom = $employee->getNom();
        $prenom = $employee->getPrenom();
        $email = $employee->getEmail();
        $mot_de_passe = $employee->getMotDePasse();

        $sql = "UPDATE employes SET 
                nom = :nom,
                prenom = :prenom,
                email = :email,
                mot_de_passe = :mot_de_passe
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour supprimer un employé par son ID
    public function deleteEmployee($id) {
        global $conn;

        $sql = "DELETE FROM employes WHERE id = $id"; // Assurez-vous que la table employes existe

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getPaginatedEmployees($results_per_page, $offset) {
      global $conn;
      $employees = array();
  
      $sql = "SELECT * FROM employes OFFSET :offset LIMIT :results_per_page";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
      $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
      $stmt->execute();
  
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $employee = new Employee(
              $row["id"],
              $row["nom"],
              $row["prenom"],
              $row["email"],
              $row["mot_de_passe"]
              // Ajoutez d'autres propriétés ici si nécessaire
          );
          array_push($employees, $employee);
      }
  
      return $employees;
  }
  

    // Méthode pour récupérer le nombre total d'employés
    public function getTotalEmployees() {
        global $conn;

        $sql = "SELECT COUNT(*) FROM employes";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    // ... Autres méthodes pour la gestion des employés ...

}
?>
