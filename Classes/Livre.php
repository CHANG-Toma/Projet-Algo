<?php

//cette classe contiendra les informations sur les livres uniquement

class Livre {
    private $id;
    private string $name;
    private string $description;

    public function __construct($id, $nom, $description) {
        $this->id = $id;
        $this->name = $nom;
        $this->description = $description;
    }

    // Getters et Setters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($nom) {
        $this->name = $nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
