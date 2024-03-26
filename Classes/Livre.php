<?php

//cette classe contiendra les informations sur les livres uniquement

class Livre {
    private $id;
    private $nom;
    private $description;

    public function __construct($nom, $description, $enStock) {
        $this->id = uniqid(); // Génère un ID unique
        $this->nom = $nom;
        $this->description = $description;
    }

    // Getters et Setters
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
