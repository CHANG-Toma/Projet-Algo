<?php

class Bibliotheque
{
    private array $books;

    public function __construct()
    {
        $this->books = [];
    }

    public function addBook(object $book): void
    {
        $TabBook = [
            'id' => $book->getId(),
            'name' => $book->getName(),
            'description' => $book->getDescription(),
            'inStock' => 1
        ];

        if (file_exists('Data/Livre.json')) {
            $json = file_get_contents('Data/Livre.json');

            if (!empty($json)) {
                $this->books = json_decode($json, true);

                foreach ($this->books as &$existingBook) {
                    if ($existingBook['name'] === $TabBook["name"]) {
                        $existingBook['inStock']++;
                        $json = json_encode($this->books);
                        file_put_contents('Data/Livre.json', $json);
                        echo "Le livre existe déjà, il a été ajouté à l'inventaire\n";
                        return;
                    }
                }
            }

            $this->books[] = $TabBook;
            $json = json_encode($this->books);
            file_put_contents('Data/Livre.json', $json);
            echo "\n" . "Le livre a été ajouté à la bibliothèque\n";
        }
    }

    public function deleteBook($id)
    {
        // supprime un livre de la bibliothèque
    }

    public function findBook($id)
    {
        foreach ($this->books as $book) {
            if ($book['id'] === $id) {
                return $book;
            }
        }
        return null;
    }

    public function sortBooks()
    {
        // trie les livres par ordre alphabétique
    }

    public function displayBook($id)
    {
        // affiche un livre
    }

    public function displayBooks()
    {
        // affiche tous les livres
    }

    public function modifyBook($id, $name, $description, $inStock)
    {
        // modifie un livre
    }
}
