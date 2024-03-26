<?php

// Cette classe contiendra les fonctions de gestion de la bibliothèque
// Les scripts seront réalisés ici

class Bibliotheque {
    private $books = [];

    public function addBook($book) {
        $this->books[] = $book;
        $json = json_encode($this->books);
        file_put_contents('../Data/Book.json', $json); // sauvegarde les livres dans un fichier json
    }

    public function deleteBook($id) {
        // supprime un livre de la bibliothèque
    }

    public function findBook($id) {
        // fonction du professeur pour trouver un livre
    }

    public function sortBooks() {
        // trie les livres par ordre alphabétique
    }

    public function displayBook($id) {
        // affiche un livre
    }

    public function displayBooks() {
        // affiche tous les livres
    }

    public function modifyBook($id, $name, $description, $inStock) {
        // modifie un livre
    }
}
