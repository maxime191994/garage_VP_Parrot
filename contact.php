<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous</title>
    <!-- Lien vers Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Lien vers votre fichier CSS personnalisé -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h1>Contactez-nous</h1>

        <?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérez les données du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse_mail = $_POST["adresse_mail"];
    $numero_telephone = $_POST["numero_telephone"];
    $sujet = $_POST["sujet"];
    $message = $_POST["message"];

    require 'vendor/autoload.php'; // Chargez SendGrid via Composer

    try {
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($adresse_mail, "$nom $prenom"); // Expéditeur
        $email->setSubject("Message de $nom $prenom - $sujet"); // Sujet de l'e-mail
        $email->addTo("VPGarage@outlook.fr", "Destinataire"); // Adresse e-mail du destinataire
        $email->addContent("text/plain", $message); // Contenu texte de l'e-mail

        // Créez un objet SendGrid avec votre clé API
        $sendgrid = new \SendGrid(SENDGRID_API_KEY);

        // Envoyez l'e-mail
        $response = $sendgrid->send($email);

        // Affichez la réponse
        echo "<p class='alert alert-success'>Votre message a été envoyé avec succès. Nous vous répondrons bientôt. 
        <a href='index.php' class='btn btn-secondary'>Retour à l'accueil</a></p>";
    } catch (\SendGrid\Mail\TypeException $e) {
        echo "Erreur lors de la construction de l'e-mail : {$e->getMessage()}";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$e->getMessage()}";
    }
}
?>

        <form method="post" action="contact.php">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="adresse_mail">Adresse e-mail :</label>
                <input type="email" class="form-control" id="adresse_mail" name="adresse_mail" required>
            </div>

            <div class="form-group">
                <label for="numero_telephone">Numéro de téléphone :</label>
                <input type="tel" class="form-control" id="numero_telephone" name="numero_telephone">
            </div>

            <div class="form-group">
                <label for="sujet">Sujet :</label>
                <select class="form-control" id="sujet" name="sujet">
                    <?php
                    // Exécuter la requête SQL pour obtenir les sujets depuis la table services
                    try {
                        $query = "SELECT nom FROM services";
                        $result = $conn->query($query);

                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row["nom"] . "'>" . $row["nom"] . "</option>";
                        }
                    } catch (PDOException $e) {
                        echo "Erreur lors de la récupération des sujets : " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="message">Message :</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
    <?php include('footer.php'); ?>

    <!-- Scripts Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
