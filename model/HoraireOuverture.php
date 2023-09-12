<?php

class HoraireOuverture {
    private $id;
    private $jourSemaine;
    private $heureOuverture;
    private $heureFermeture;

    public function __construct($id, $jourSemaine, $heureOuverture, $heureFermeture) {
        $this->id = $id;
        $this->jourSemaine = $jourSemaine;
        $this->heureOuverture = $heureOuverture;
        $this->heureFermeture = $heureFermeture;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getJourSemaine() {
        return $this->jourSemaine;
    }

    public function setJourSemaine($jourSemaine) {
        $this->jourSemaine = $jourSemaine;
    }

    public function getHeureOuverture() {
        return $this->heureOuverture;
    }

    public function setHeureOuverture($heureOuverture) {
        $this->heureOuverture = $heureOuverture;
    }

    public function getHeureFermeture() {
        return $this->heureFermeture;
    }

    public function setHeureFermeture($heureFermeture) {
        $this->heureFermeture = $heureFermeture;
    }

    // Autres méthodes de gestion des horaires d'ouverture
    // ...
}
