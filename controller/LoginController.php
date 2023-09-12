<?php
require_once "../config.php";

class LoginController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        $email = $this->conn->real_escape_string($email);
        $password = $this->conn->real_escape_string($password);

        // Recherche dans la table des administrateurs
        $sql = "SELECT * FROM administrateurs WHERE email = '$email' AND mot_de_passe = '$password'";
        $result = $this->conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $_SESSION["user_id"] = $row["id"]; // Stocker l'ID de l'administrateur dans la session
            return true; // Connexion réussie en tant qu'administrateur
        } else {
            // Si aucune correspondance n'est trouvée dans la table des administrateurs, recherche dans la table des employés
            $sql = "SELECT * FROM employes WHERE email = '$email' AND mot_de_passe = '$password'";
            $result = $this->conn->query($sql);

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $_SESSION["user_id"] = $row["id"]; // Stocker l'ID de l'employé dans la session
                return true; // Connexion réussie en tant qu'employé
            } else {
                return false; // Identifiants invalides
            }
        }
    }

    public function logout() {
        unset($_SESSION["user_id"]); // Supprimer l'ID de l'utilisateur de la session
    }
}

$loginController = new LoginController($conn); // Passer la connexion à l'instanciation du contrôleur
?>
