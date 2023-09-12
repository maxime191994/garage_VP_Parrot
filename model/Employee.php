<?php
class Employee {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $motDePasse;

    public function __construct($id, $nom, $prenom, $email, $motDePasse) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
    }

    // Getter pour l'ID de l'employé
    public function getId() {
        return $this->id;
    }

    // Setter pour l'ID de l'employé
    public function setId($id) {
        $this->id = $id;
    }

    // Getter pour le nom de l'employé
    public function getNom() {
        return $this->nom;
    }

    // Setter pour le nom de l'employé
    public function setNom($nom) {
        $this->nom = $nom;
    }

    // Getter pour le prénom de l'employé
    public function getPrenom() {
        return $this->prenom;
    }

    // Setter pour le prénom de l'employé
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    // Getter pour l'email de l'employé
    public function getEmail() {
        return $this->email;
    }

    // Setter pour l'email de l'employé
    public function setEmail($email) {
        $this->email = $email;
    }

    // Getter pour le mot de passe de l'employé
    public function getMotDePasse() {
        return $this->motDePasse;
    }

    // Setter pour le mot de passe de l'employé
    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }

    // Autres méthodes de gestion des employés
    // ...

}
