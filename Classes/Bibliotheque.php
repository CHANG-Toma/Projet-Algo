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
        // Initialise un tableau avec les informations du livre
        $TabBook = [
            'id' => $book->getId(),
            'name' => $book->getName(),
            'description' => $book->getDescription(),
            'inStock' => 1
        ];

        // Vérifie si le fichier existe
        if (file_exists('Data/Livre.json')) {
            $json = file_get_contents('Data/Livre.json');

            // Si le fichier n'est pas vide
            if (!empty($json)) {
                // On récupère les données du fichier
                $this->books = json_decode($json, true);

                // On vérifie si le livre existe déjà
                foreach ($this->books as &$existingBook) {
                    // Si le livre existe déjà, on incrémente le stock de 1 et on sauvegarde les données
                    if ($existingBook['name'] === $TabBook["name"]) {
                        $existingBook['inStock']++;
                        $json = json_encode($this->books);
                        file_put_contents('Data/Livre.json', $json);
                        // On affiche un message pour informer l'utilisateur
                        echo "Le livre existe déjà, il a été ajouté à l'inventaire\n";
                        $this->history(['action' => 'Ajout', 'Nom du livre' => $TabBook['name']]);
                        return;
                    }
                }
            }

            // Si le livre n'existe pas, on l'ajoute à la bibliothèque 
            // et on sauvegarde les données dans le fichier
            $this->books[] = $TabBook;
            $json = json_encode($this->books);
            file_put_contents('Data/Livre.json', $json);
            // On affiche un message pour informer l'utilisateur
            echo "\n" . "Le livre a été ajouté à la bibliothèque\n";
            $this->history(['action' => 'Ajout', 'Nom du livre' => $TabBook['name']]);
        }
    }

    public function deleteBook($data, $method): void
    {
        // Vérifie si le fichier existe
        if (file_exists('Data/Livre.json')) {
            $json = file_get_contents('Data/Livre.json');

            // Si le fichier n'est pas vide
            if (!empty($json)) {
                // On récupère les données du fichier 
                $this->books = json_decode($json, true);

                // On vérifie si le livre existe déjà
                foreach ($this->books as $key => &$existingBook) {
                    // Si le livre existe déjà, on décrémente la quantité en fonction de la méthode de recherche

                    if ($method === 'name' && $existingBook['name'] === $data) {
                        $existingBook['inStock']--;

                        // Si la quantité est inférieure ou égale à 0 on supprime le livre 
                        if ($existingBook['inStock'] <= 0) {
                            unset($this->books[$key]);
                        }

                        $json = json_encode($this->books);
                        file_put_contents('Data/Livre.json', $json);
                        // On affiche un message pour informer l'utilisateur
                        echo "Le livre a été supprimé de la bibliothèque\n";
                        $this->history(['action' => 'Suppression', 'Nom du livre' => $data]);
                        return;
                    } elseif ($method === 'description' && $existingBook['description'] === $data) {
                        $existingBook['inStock']--;

                        // Si la quantité est inférieure ou égale à 0, on supprime le livre
                        if ($existingBook['inStock'] <= 0) {
                            unset($this->books[$key]);
                        }

                        $json = json_encode($this->books);
                        file_put_contents('Data/Livre.json', $json);
                        // On affiche un message pour informer l'utilisateur
                        echo "Le livre a été supprimé de la bibliothèque\n";
                        $this->history(['action' => 'Suppression', 'Nom du livre' => $data]);
                        return;
                    } elseif ($method === 'id' && $existingBook['id'] === $data) {
                        $existingBook['inStock']--;

                        // Si la quantité est inférieure ou égale à 0, on supprime le livre
                        if ($existingBook['inStock'] <= 0) {
                            unset($this->books[$key]);
                        }

                        $json = json_encode($this->books);
                        file_put_contents('Data/Livre.json', $json);
                        // On affiche un message pour informer l'utilisateur
                        echo "Le livre a été supprimé de la bibliothèque\n";
                        $this->history(['action' => 'Suppression', 'Nom du livre' => $data]);
                        return;
                    } else {
                        // On affiche un message pour informer l'utilisateur
                        echo "Le livre est introuvable :( \n";
                    }
                }
            }
        }
    }

    public function findBook()
    {
        // recherche un livre        
    }

    public function sortBooks()
    {
        // trie les livres par ordre alphabétique
    }

    public function displayBook($name): void
    {
        // Vérifie si le fichier existe
        if (file_exists('Data/Livre.json')) {
            $json = file_get_contents('Data/Livre.json');

            // Si le fichier n'est pas vide
            if (!empty($json)) {
                // On récupère les données du fichier
                $this->books = json_decode($json, true);

                // On vérifie si le livre existe déjà
                foreach ($this->books as $existingBook) {
                    // Si le livre existe déjà, on affiche les informations du livre
                    if ($existingBook['name'] === $name) {
                        echo " \nInformations sur le livre :\n";
                        echo "ID du livre : " . $existingBook['id'] . "\n";
                        echo "Nom du livre : " . $existingBook['name'] . "\n";
                        echo "Description du livre : " . $existingBook['description'] . "\n";
                        echo "Quantité en stock : " . $existingBook['inStock'] . "\n" . "\n";
                        $this->history(['action' => 'Affichage', 'Nom du livre' => $name]);
                        return;
                    }
                }
                echo "\n Le livre est introuvable :( \n";
                $this->history(['action' => 'Affichage', 'Nom du livre' => $name]);
            }
        }
    }

    public function displayBooks()
    {
        // affiche tous les livres
    }

    public function modifyBook($id, $name, $description, $inStock)
    {
        // modifie un livre
    }

    private function history(array $data)
    {
        // Vérifie si l'action est présente dans le tableau pour déterminer le type de log 
        if ($data["action"] === "Suppression") {
            // On initialise logData avec le type de log de suppression "WARNING"
            $logData = "[" . date('Y-m-d H:i:s') . "] - WARNING - " . json_encode($data) . "\n";
        } else {
            // On initialise logData avec le type de log d'ajout "INFO"
            $logData = "[" . date('Y-m-d H:i:s') . "] - INFO - " . json_encode($data) . "\n";
        }

        // On enregistre l'action dans le fichier de log
        file_put_contents('log/actions.log', $logData, FILE_APPEND);
    }
}
