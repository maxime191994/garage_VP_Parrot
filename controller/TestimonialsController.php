<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../model/Testimonial.php"; 

class TestimonialsController {

    // Méthode pour récupérer la liste des témoignages
    public function listTestimonials() {
        global $conn;
        $testimonials = array();

        $sql = "SELECT * FROM temoignages";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $testimonial = new Testimonial(
                    $row["id"],
                    $row["nom"],
                    $row["commentaire"],
                    $row["note"],
                    $row["date_ajout"],
                    $row["approuve"]
                );
                array_push($testimonials, $testimonial);
            }
        }

        return $testimonials;
    }

    // Méthode pour récupérer un témoignage par son ID
    public function getTestimonial($id) {
        global $conn;

        $sql = "SELECT * FROM temoignages WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt !== false && $stmt->rowCount() === 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $testimonial = new Testimonial(
                $row["id"],
                $row["nom"],
                $row["commentaire"],
                $row["note"],
                $row["date_ajout"],
                $row["approuve"]
            );
            return $testimonial;
        } else {
            return null;
        }
    }

    // Méthode pour créer un témoignage
    public function createTestimonial($testimonial) {
        global $conn;

        $nom = $testimonial->getNom();
        $commentaire = $testimonial->getCommentaire();
        $note = $testimonial->getNote();
        $approuve = $testimonial->isApprouve();

        $sql = "INSERT INTO temoignages (nom, commentaire, note, approuve)
                VALUES (:nom, :commentaire, :note, :approuve)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':approuve', $approuve);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour mettre à jour un témoignage
    public function updateTestimonial($testimonial) {
        global $conn;

        $id = $testimonial->getId();
        $nom = $testimonial->getNom();
        $commentaire = $testimonial->getCommentaire();
        $note = $testimonial->getNote();
        $approuve = $testimonial->isApprouve();

        $sql = "UPDATE temoignages SET 
                nom = :nom,
                commentaire = :commentaire,
                note = :note,
                approuve = :approuve
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':approuve', $approuve);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour supprimer un témoignage par son ID
    public function deleteTestimonial($id) {
        global $conn;

        $sql = "DELETE FROM temoignages WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour approuver un témoignage
    public function approveTestimonial($id) {
        global $conn;

        $sql = "UPDATE temoignages SET approuve = TRUE WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour désapprouver un témoignage
    public function disapproveTestimonial($id) {
        global $conn;

        $sql = "UPDATE temoignages SET approuve = FALSE WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Méthode pour récupérer le nombre total de témoignages
    public function getTotalTestimonials() {
        global $conn;

        $sql = "SELECT COUNT(*) FROM temoignages";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    // ... Autres méthodes pour la gestion des témoignages ...

}
?>
