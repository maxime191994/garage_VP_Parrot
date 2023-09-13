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
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require_once "config.php";

        require 'vendor/autoload.php'; // Chargez PHPMailer via Composer

        // Vérifiez si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Récupérez les données du formulaire
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $adresse_mail = $_POST["adresse_mail"];
            $numero_telephone = $_POST["numero_telephone"];
            $sujet = $_POST["sujet"];
            $message = $_POST["message"];

            // Créez une instance de PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Paramètres du serveur SMTP (utilisation de variables d'environnement)
                $mail->isSMTP();
                $mail->Host = 'smtp.sendgrid.net'; // Hôte SMTP de SendGrid
                $mail->Port = 587; // Port SMTP de SendGrid (peut être différent)
                $mail->SMTPAuth = true;
                $mail->Username = 'apikey'; // Utilisez 'apikey' comme nom d'utilisateur
                $mail->Password = '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'; // Remplacez par votre clé API SendGrid
                $mail->SMTPSecure = 'tls'; // Utilisez 'tls' pour le chiffrement

                // Destinataire et expéditeur
                $mail->setFrom($adresse_mail, $nom);
                $mail->addAddress('VPGarage@outlook.fr'); // Adresse e-mail du destinataire

                // Contenu du message
                $mail->isHTML(false);
                $mail->Encoding = 'base64'; // Utiliser l'encodage base64
                $mail->ContentType = 'text/plain;charset=UTF-8'; // Spécifier l'encodage UTF-8
                $mail->Subject = mb_encode_mimeheader("Message de $nom $prenom - $sujet", "UTF-8");
                $mail->Body = "Message : $message\n\nNom : $nom\nPrénom : $prenom\n
                Adresse e-mail : $adresse_mail\nNuméro de téléphone : $numero_telephone";

                // Envoyer l'e-mail
                $mail->send();
                echo "<p class='alert alert-success'>Votre message a été envoyé avec succès. Nous vous répondrons bientôt. 
                <a href='index.php' class='btn btn-secondary'>Retour à l'accueil</a></p>";
            } catch (Exception $e) {
                echo "<p class='alert alert-danger'>Une erreur s'est produite lors de l'envoi de votre message : {$mail->ErrorInfo}
                <a href='index.php' class='btn btn-secondary'>Retour à l'accueil</a></p>";
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
