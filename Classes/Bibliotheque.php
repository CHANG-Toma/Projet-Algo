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
                        // On stock l'action pour les logs
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

    public function modifyBook($column, $bookdata)
    {
        // Vérifie si le fichier existe
        if (file_exists('Data/Livre.json')) {
            $json = file_get_contents('Data/Livre.json');
            $this->books = json_decode($json, true);

            // Parcourir les livres pour trouver celui à modifier
            foreach ($this->books as &$existingBook) {
                if ($existingBook[$column] === $bookdata["book"]) {
                    // Mise à jour des informations du livre
                    $existingBook['name'] = $bookdata["newName"];
                    $existingBook['description'] = $bookdata["description"];

                    if ($bookdata["inStock"] === 'non') {
                        $existingBook["inStock"] = 0;
                    } else if ($bookdata["inStock"] === 'oui' && $existingBook["inStock"] === 0) { {
                            $existingBook["inStock"]++;
                        }

                        // Sauvegarder les modifications dans le fichier
                        $json = json_encode($this->books);
                        file_put_contents('Data/Livre.json', $json);

                        echo "Les informations du livre ont été mises à jour.\n";
                        $this->history(['action' => 'Modification', 'ID du livre' => $existingBook['id']]);
                        return;
                    }
                }

                echo "Aucun livre trouvé avec cette donnée.\n";
            }
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
                        // On stock l'action pour les logs
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
                        // On stock l'action pour les logs
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

    public function sortBooks($column, $order = 'asc')
    {
        if (file_exists('Data/Livre.json')) {
            $json = file_get_contents('Data/Livre.json');
            $this->books = json_decode($json, true);

            if (!empty($this->books)) {
                $sortedBooks = $this->mergeSort($this->books, $column, $order);
                foreach ($sortedBooks as $book) {
                    echo "ID: " . $book['id'] . "\n";
                    echo "Nom: " . $book['name'] . "\n";
                    echo "Description: " . $book['description'] . "\n";
                    echo "En stock: " . ($book['inStock'] ? "Oui" : "Non") . "\n\n";
                }
            } else {
                echo "Aucun livre à trier.\n";
            }
        } else {
            echo "Fichier de données introuvable.\n";
        }
    }

    private function mergeSort($books, $column, $order)
    {
        if (count($books) < 2) {
            return $books;
        }

        $mid = intdiv(count($books), 2);
        $left = array_slice($books, 0, $mid);
        $right = array_slice($books, $mid);

        return $this->merge(
            $this->mergeSort($left, $column, $order),
            $this->mergeSort($right, $column, $order),
            $column,
            $order
        );
    }

    private function merge($left, $right, $column, $order)
    {
        $result = [];
        $i = 0;
        $j = 0;

        while ($i < count($left) && $j < count($right)) {
            if (
                ($order === 'asc' && $left[$i][$column] <= $right[$j][$column]) ||
                ($order === 'desc' && $left[$i][$column] > $right[$j][$column])
            ) {
                $result[] = $left[$i++];
            } else {
                $result[] = $right[$j++];
            }
        }

        while ($i < count($left)) {
            $result[] = $left[$i++];
        }

        while ($j < count($right)) {
            $result[] = $right[$j++];
        }

        return $result;
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
                        // On stock l'action pour les logs
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
        // Vérifie si le fichier existe
        if (file_exists('Data/Livre.json')) {
            $json = file_get_contents('Data/Livre.json');
            $books = json_decode($json, true);

            if (!empty($books)) {
                echo "\nListe des livres disponibles :\n";
                foreach ($books as $book) {
                    echo "ID: " . $book['id'] . "\n";
                    echo "Nom: " . $book['name'] . "\n";
                    echo "Description: " . $book['description'] . "\n";
                    echo "En stock: " . ($book['inStock'] ? "Oui" : "Non") . "\n\n";
                }
            } else {
                echo "\nAucun livre disponible.\n";
            }
        } else {
            echo "\nFichier de données introuvable.\n";
        }
    }

    public function findBook($column, $value): void
    {
        // Récupère les informations des livres
        $json = file_get_contents('Data/Livre.json');
        $this->books = json_decode($json, true);

        // Trie rapide des livres par ordre alphabétique
        $this->fastSort($this->books);
        $this->history(['action' => 'Tri', 'Type de tri' => 'Rapide']);
        //print_r($this->books);

        // Recherche binaire 
        $left = 0; // Index de début
        $right = count($this->books) - 1; // Index de fin

        while ($left <= $right) {
            // Calcul le milieu du tableau pour la recherche binaire
            $mid = floor(($left + $right) / 2);

            // Vérifie si le livre du milieu existe
            if (isset($this->books[$mid])) {

                // Récupère le livre du milieu
                $book = $this->books[$mid];

                if (isset($book[$column]) && $book[$column] == $value) {
                    // Livre trouvé on montre les informations
                    echo "\nLivre trouvé :\n";
                    echo "ID: " . $book['id'] . "\n";
                    echo "Nom: " . $book['name'] . "\n";
                    echo "Description: " . $book['description'] . "\n";
                    echo "En Stock : " . $book['inStock'] . "\n";
                    $this->history(['action' => 'Recherche', 'Nom du livre' => $book['name']]);
                    return;
                } elseif (isset($book[$column]) && $book[$column] < $value) {
                    // Si la valeur est plus grande, on ignore la partie gauche
                    $left = $mid + 1;
                } else {
                    // Si la valeur est plus petite, on ignore la partie droite
                    $right = $mid - 1;
                }
            } else {
                // Si le livre du milieu n'existe pas, on sort de la boucle
                break;
            }
        }

        // Si le livre n'est pas trouvé
        echo "\nLivre non trouvé.\n";
    }


    private function history(array $data): void
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

    private function fastSort(array $array): array
    {
        // Vérifie si le tableau est vide ou contient un seul élément
        if (count($array) <= 1) {
            return $array;
        }

        // Initialisation des variables pivot, gauche et droite

        $pivot = $array[0]; // On prend le premier élément du tableau comme pivot

        $left = []; // Tableau pour les éléments plus petits que le pivot

        $right = []; // Tableau pour les éléments plus grands que le pivot

        // On parcourt le tableau à partir du deuxième élément
        for ($i = 1; $i < count($array); $i++) {
            // On compare les éléments du tableau avec le pivot
            if (isset($array[$i]) && $array[$i] < $pivot) {
                // Si l'élément est plus petit que le pivot, on l'ajoute au tableau de gauche
                $left[] = $array[$i];
            } else {
                // Si l'élément est plus grand que le pivot, on l'ajoute au tableau de droite
                if (isset($array[$i])) {
                    $right[] = $array[$i];
                } else {
                    $right[] = $pivot;
                }

            }
        }

        // On retourne le tableau trié en fusionnant les tableaux de gauche, pivot et droite
        return array_merge($this->fastSort($left), [$pivot], $this->fastSort($right));
    }
}
