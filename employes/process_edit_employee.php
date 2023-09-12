<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des employés</title>

    <!-- Lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Lien vers la police Google Fonts (Ubuntu) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">

    <!-- Lien vers votre fichier CSS personnalisé (styles.css) -->
    <link rel="stylesheet" href="../css/styles.css">
    
    <!-- Lien vers les scripts JavaScript Bootstrap (jQuery, Popper.js, Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

<?php
require_once __DIR__ . '/../config.php'; // Inclure la configuration de la base de données
require_once __DIR__ . '/../model/Employee.php'; // Inclure la classe Employee
require_once __DIR__ . '/../controller/EmployesController.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'ID de l'employé depuis le formulaire
    $employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : null;

    // Vérifier si l'ID est valide
    if ($employee_id !== null && is_numeric($employee_id)) {
        // Créer une instance d'Employee avec l'ID
        $employeesController = new EmployeesController();
        $employee = $employeesController->getEmployee($employee_id);

        // Vérifier si l'employé existe
        if ($employee !== null) {
            // Récupérer et vérifier les autres données du formulaire
            $nom = isset($_POST['nom']) ? $_POST['nom'] : $employee->getNom();
            $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : $employee->getPrenom();
            $email = isset($_POST['email']) ? $_POST['email'] : $employee->getEmail();

            // Vérifier le mot de passe
            $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : null;
            if ($mot_de_passe === null) {
                // Si le champ mot de passe est vide, conservez le mot de passe existant
                $mot_de_passe = $employee->getMotDePasse();
            } else {
                // Si un nouveau mot de passe est fourni, hachez-le
                $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            }

            // Créer une nouvelle instance d'Employee avec les données mises à jour
            $updatedEmployee = new Employee(
                $employee_id,
                $nom,
                $prenom,
                $email,
                $mot_de_passe
            );

            // Mettre à jour l'employé dans la base de données
            $success = $employeesController->updateEmployee($updatedEmployee);

            if ($success) {
                // Rediriger vers une page de succès ou afficher un message de réussite
                header('Location: list_employes.php');
                exit;
            } else {
                // Afficher un message d'erreur
                echo "Erreur lors de la mise à jour de l'employé.";
            }
        } else {
            // L'employé n'existe pas, gérer cette situation en conséquence
            echo "L'employé avec l'ID $employee_id n'existe pas.";
        }
    } else {
        // L'ID de l'employé n'est pas valide, gérer cette situation en conséquence
        echo "ID d'employé non valide.";
    }
} else {
    // Le formulaire n'a pas été soumis, gérer cette situation en conséquence
    echo "Le formulaire n'a pas été soumis.";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" 
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" 
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
