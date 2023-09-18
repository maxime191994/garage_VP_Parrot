<?php

class HoraireOuverture {
    private $id;
    private $jourSemaine;
    private $heureOuvertureMatin;
    private $heureFermetureMatin;
    private $heureOuvertureAprem;
    private $heureFermetureAprem;

    public function __construct($id, $jourSemaine, $heureOuvertureMatin, $heureFermetureMatin, $heureOuvertureAprem, $heureFermetureAprem) {
        $this->id = $id;
        $this->jourSemaine = $jourSemaine;
        $this->heureOuvertureMatin = $heureOuvertureMatin;
        $this->heureFermetureMatin = $heureFermetureMatin;
        $this->heureOuvertureAprem = $heureOuvertureAprem;
        $this->heureFermetureAprem = $heureFermetureAprem;
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

    public function getHeureOuvertureMatin() {
        return $this->heureOuvertureMatin;
    }

    public function setHeureOuvertureMatin($heureOuvertureMatin) {
        $this->heureOuvertureMatin = $heureOuvertureMatin;
    }

    public function getHeureFermetureMatin() {
        return $this->heureFermetureMatin;
    }

    public function setHeureFermetureMatin($heureFermetureMatin) {
        $this->heureFermetureMatin = $heureFermetureMatin;
    }

    public function getHeureOuvertureAprem() {
        return $this->heureOuvertureAprem;
    }

    public function setHeureOuvertureAprem($heureOuvertureAprem) {
        $this->heureOuvertureAprem = $heureOuvertureAprem;
    }

    public function getHeureFermetureAprem() {
        return $this->heureFermetureAprem;
    }

    public function setHeureFermetureAprem($heureFermetureAprem) {
        $this->heureFermetureAprem = $heureFermetureAprem;
    }

    // Autres méthodes de gestion des horaires d'ouverture
    // ...
}

