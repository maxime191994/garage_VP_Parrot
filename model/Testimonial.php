<?php

class Testimonial {
    private $id;
    private $nom;
    private $commentaire;
    private $note;
    private $dateAjout;
    private $approuve;

    public function __construct($id, $nom, $commentaire, $note, $dateAjout, $approuve) {
        $this->id = $id;
        $this->nom = $nom;
        $this->commentaire = $commentaire;
        $this->note = $note;
        $this->dateAjout = $dateAjout;
        $this->approuve = $approuve;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function getDateAjout() {
        return $this->dateAjout;
    }

    public function setDateAjout($dateAjout) {
        $this->dateAjout = $dateAjout;
    }

    public function isApprouve() {
        return $this->approuve;
    }

    public function setApprouve($approuve) {
        $this->approuve = $approuve;
    }

    // Autres méthodes de gestion des témoignages
    // ...
}

?>
