<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer un service</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <?php
    require_once __DIR__ . '/../config.php'; // Inclure la configuration de la base de données
    require_once __DIR__ . '/../model/Service.php'; // Inclure la classe Service
    require_once __DIR__ . '/../controller/ServicesController.php';

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer l'ID du service depuis le formulaire
        $service_id = isset($_POST['service_id']) ? $_POST['service_id'] : null;

        // Vérifier si l'ID est valide
        if ($service_id !== null && is_numeric($service_id)) {
            // Créer une instance de Service avec l'ID
            $servicesController = new ServicesController();
            $service = $servicesController->getService($service_id);

            // Vérifier si le service existe
            if ($service !== null) {
                // Récupérer et vérifier les autres données du formulaire
                $nom = isset($_POST['nom']) ? $_POST['nom'] : $service->getNom();
                $description = isset($_POST['description']) ? $_POST['description'] : $service->getDescription();

                // Créer une nouvelle instance de Service avec les données mises à jour
                $updatedService = new Service(
                    $service_id,
                    $nom,
                    $description
                );

                // Mettre à jour le service dans la base de données
                $success = $servicesController->updateService($updatedService);

                if ($success) {
                    // Rediriger vers une page de succès ou afficher un message de réussite
                    header('Location: list_services.php');
                    exit;
                } else {
                    // Afficher un message d'erreur
                    echo "Erreur lors de la mise à jour du service.";
                }
            } else {
                // Le service n'existe pas, gérer cette situation en conséquence
                echo "Le service avec l'ID $service_id n'existe pas.";
            }
        } else {
            // L'ID du service n'est pas valide, gérer cette situation en conséquence
            echo "ID de service non valide.";
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
