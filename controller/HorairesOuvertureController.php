<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../model/HoraireOuverture.php";

class HorairesOuvertureController {

    public function listHorairesOuverture() {
        global $conn;
        $horairesOuverture = array();

        $sql = "SELECT * FROM horaires_ouverture";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $horaireOuverture = new HoraireOuverture(
                    $row["id"],
                    $row["jour_semaine"],
                    $row["heure_ouverture_matin"],
                    $row["heure_fermeture_matin"],
                    $row["heure_ouverture_aprem"],
                    $row["heure_fermeture_aprem"]
                );
                array_push($horairesOuverture, $horaireOuverture);
            }
        }

        return $horairesOuverture;
    }

    public function getHoraireOuverture($id) {
        global $conn;

        $sql = "SELECT * FROM horaires_ouverture WHERE id = $id";
        $result = $conn->query($sql);

        if ($result !== false && $result->rowCount() === 1) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $horaireOuverture = new HoraireOuverture(
                $row["id"],
                $row["jour_semaine"],
                $row["heure_ouverture_matin"],
                $row["heure_fermeture_matin"],
                $row["heure_ouverture_aprem"],
                $row["heure_fermeture_aprem"]
            );
            return $horaireOuverture;
        } else {
            return null;
        }
    }

    public function createHoraireOuverture($horaireOuverture) {
        global $conn;

        $jourSemaine = $horaireOuverture->getJourSemaine();
        $heureOuvertureMatin = $horaireOuverture->getHeureOuvertureMatin();
        $heureFermetureMatin = $horaireOuverture->getHeureFermetureMatin();
        $heureOuvertureAprem = $horaireOuverture->getHeureOuvertureAprem();
        $heureFermetureAprem = $horaireOuverture->getHeureFermetureAprem();

        $sql = "INSERT INTO horaires_ouverture (jour_semaine, heure_ouverture_matin, heure_fermeture_matin, heure_ouverture_aprem, heure_fermeture_aprem)
                VALUES (:jour_semaine, :heure_ouverture_matin, :heure_fermeture_matin, :heure_ouverture_aprem, :heure_fermeture_aprem)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':jour_semaine', $jourSemaine);
        $stmt->bindParam(':heure_ouverture_matin', $heureOuvertureMatin);
        $stmt->bindParam(':heure_fermeture_matin', $heureFermetureMatin);
        $stmt->bindParam(':heure_ouverture_aprem', $heureOuvertureAprem);
        $stmt->bindParam(':heure_fermeture_aprem', $heureFermetureAprem);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateHoraireOuverture($horaireOuverture) {
        global $conn;

        $id = $horaireOuverture->getId();
        $jourSemaine = $horaireOuverture->getJourSemaine();
        $heureOuvertureMatin = $horaireOuverture->getHeureOuvertureMatin();
        $heureFermetureMatin = $horaireOuverture->getHeureFermetureMatin();
        $heureOuvertureAprem = $horaireOuverture->getHeureOuvertureAprem();
        $heureFermetureAprem = $horaireOuverture->getHeureFermetureAprem();

        $sql = "UPDATE horaires_ouverture SET 
                jour_semaine = :jour_semaine,
                heure_ouverture_matin = :heure_ouverture_matin,
                heure_fermeture_matin = :heure_fermeture_matin,
                heure_ouverture_aprem = :heure_ouverture_aprem,
                heure_fermeture_aprem = :heure_fermeture_aprem
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':jour_semaine', $jourSemaine);
        $stmt->bindParam(':heure_ouverture_matin', $heureOuvertureMatin);
        $stmt->bindParam(':heure_fermeture_matin', $heureFermetureMatin);
        $stmt->bindParam(':heure_ouverture_aprem', $heureOuvertureAprem);
        $stmt->bindParam(':heure_fermeture_aprem', $heureFermetureAprem);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // ...

    public function deleteHoraireOuverture($id) {
        global $conn;
    
        $sql = "DELETE FROM horaires_ouverture WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getPaginatedHorairesOuverture($results_per_page, $offset) {
        global $conn;
        $horairesOuverture = array();
    
        $sql = "SELECT * FROM horaires_ouverture OFFSET :offset LIMIT :results_per_page";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
        $stmt->execute();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $horaireOuverture = new HoraireOuverture(
                $row["id"],
                $row["jour_semaine"],
                $row["heure_ouverture_matin"],
                $row["heure_fermeture_matin"],
                $row["heure_ouverture_aprem"],
                $row["heure_fermeture_aprem"]
            );
            array_push($horairesOuverture, $horaireOuverture);
        }
    
        return $horairesOuverture;
    }
    
    public function getTotalHorairesOuverture() {
        global $conn;
    
        $sql = "SELECT COUNT(*) FROM horaires_ouverture";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        return $stmt->fetchColumn();
    }
}
?>
