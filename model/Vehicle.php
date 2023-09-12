<?php

class Vehicle {
    private $id;
    private $marque;
    private $nomModele;
    private $anneeMiseEnCirculation;
    private $prix;
    private $kilometrage;
    private $description;
    private $imagePrincipale;
    private $galerieImages;
    private $caracteristiques;
    private $options;

    public function __construct($id, $marque, $nomModele, $anneeMiseEnCirculation, $prix, $kilometrage, $description, $imagePrincipale, $galerieImages, $caracteristiques, $options) {
        $this->id = $id;
        $this->marque = $marque;
        $this->nomModele = $nomModele;
        $this->anneeMiseEnCirculation = $anneeMiseEnCirculation;
        $this->prix = $prix;
        $this->kilometrage = $kilometrage;
        $this->description = $description;
        $this->imagePrincipale = $imagePrincipale;
        $this->galerieImages = $galerieImages;
        $this->caracteristiques = $caracteristiques;
        $this->options = $options;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMarque() {
        return $this->marque;
    }

    public function setMarque($marque) {
        $this->marque = $marque;
    }

    public function getNomModele() {
        return $this->nomModele;
    }

    public function setNomModele($nomModele) {
        $this->nomModele = $nomModele;
    }

    public function getAnneeMiseEnCirculation() {
        return $this->anneeMiseEnCirculation;
    }

    public function setAnneeMiseEnCirculation($anneeMiseEnCirculation) {
        $this->anneeMiseEnCirculation = $anneeMiseEnCirculation;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getKilometrage() {
        return $this->kilometrage;
    }

    public function setKilometrage($kilometrage) {
        $this->kilometrage = $kilometrage;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getImagePrincipale() {
        return $this->imagePrincipale;
    }

    public function setImagePrincipale($imagePrincipale) {
        $this->imagePrincipale = $imagePrincipale;
    }

    public function getGalerieImages() {
        return $this->galerieImages;
    }

    public function setGalerieImages($galerieImages) {
        $this->galerieImages = $galerieImages;
    }

    public function getCaracteristiques() {
        return $this->caracteristiques;
    }

    public function setCaracteristiques($caracteristiques) {
        $this->caracteristiques = $caracteristiques;
    }

    public function getOptions() {
        // Si les options sont déjà sous forme de tableau, retournez-les directement
        if (is_array($this->options)) {
            return $this->options;
        }
    
        // Si les options sont une chaîne de caractères non vide, séparez-la en un tableau en utilisant la virgule comme séparateur
        if (!empty($this->options)) {
            return explode(', ', $this->options);
        }
    
        // Si les options sont vides, retournez un tableau vide
        return [];
    }
    
    

    public function setOptions($options) {
        $this->options = $options;
    }

    // Autres méthodes de gestion des véhicules
    // ...
}
