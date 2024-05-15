<?php

include "Classes/Bibliotheque.php";
include "Classes/Livre.php";

// Instance de la bibliothèque
$bibliotheque = new Bibliotheque();

// Fonction principale affichant le menu et gérant les interactions utilisateur
function afficherMenu()
{
    echo "\n-----------------------------------\n";
    echo " Gestion de Bibliothèque\n";
    echo "-----------------------------------\n";
    echo "1. Ajouter un livre\n";
    echo "2. Modifier un livre\n";
    echo "3. Supprimer un livre\n";
    echo "4. Afficher tous les livres\n";
    echo "5. Afficher un livre\n";
    echo "6. Trier les livres\n";
    echo "7. Rechercher un livre\n";
    echo "8. Quitter\n";
    echo "Choisissez une option : ";
}

// Boucle du programme
$continuer = true;
do {
    afficherMenu();
    $choix = trim(fgets(STDIN));
    switch ($choix) {
        case '1':
            // Logique d'ajout de livre
            echo "Entrez le nom du livre : ";
            $nom = trim(fgets(STDIN));
            echo "Entrez la description du livre : ";
            $description = trim(fgets(STDIN));
            $id = uniqid();

            $livre = new Livre($id, $nom, $description);
            $bibliotheque->addBook($livre);
            break;

        case '2':
            $bookData = [];
            // Logique de modification de livre
            echo "\nComment voulez-vous modifier ? : \n";
            echo "1. Par son nom\n";
            echo "2. Par son id\n";
            echo "Choisissez une option : ";
            $column = trim(fgets(STDIN));

            switch ($column) {
                case '1':
                    $column = 'name';
                    echo "Entrez le nom du livre à modifier : ";
                    $bookData["book"] = trim(fgets(STDIN));
                    break;
                case '2':
                    $column = 'id';
                    echo "Entrez l'id du livre à modifier : ";
                    $bookData["book"] = trim(fgets(STDIN));
                    break;
                default:
                    echo "Option non valide. Veuillez réessayer.\n";
            }

            echo "Entrez le nouveau nom du livre : ";
            $bookData["newName"] = trim(fgets(STDIN));
            echo "Entrez la nouvelle description du livre : ";
            $bookData["description"] = trim(fgets(STDIN));
            echo "Le livre est-il en stock ? (oui/non) : ";
            $bookData["inStock"] = strtolower(trim(fgets(STDIN)));

            $bibliotheque->modifyBook($column, $bookData);
            break;

        case '3':
            // Logique de suppression de livre
            // Affichage du menu de suppression
            echo "\nComment voulez-vous supprimer le livre ?\n";
            echo "1. Par son nom\n";
            echo "2. Par son commentaire\n";
            echo "3. Par son id\n";
            echo "4. Retour\n";
            echo "Choisissez une option : ";
            $choixSuppression = trim(fgets(STDIN));

            switch ($choixSuppression) {
                    // Suppression par nom
                case '1':
                    echo "\nEntrez le nom du livre à supprimer : ";
                    $nom = trim(fgets(STDIN));
                    $bibliotheque->deleteBook($nom, 'name');
                    break;
                    // Suppression par commentaire
                case '2':
                    echo "\nEntrez le commentaire du livre à supprimer : ";
                    $description = trim(fgets(STDIN));
                    $bibliotheque->deleteBook($description, 'description');
                    break;
                    // Suppression par id
                case '3':
                    echo "\nEntrez l'id du livre à supprimer : ";
                    $id = trim(fgets(STDIN));
                    $bibliotheque->deleteBook($id, 'id');
                    break;
                    // Retour
                case '4':
                    break;
                default:
                    echo "\nOption non valide. Veuillez réessayer.\n";
            }
            break;

        case '4':
            // Logique d'affichage de tous les livres
            $bibliotheque->displayBooks();
            break;

        case '5':
            // Logique d'affichage d'un livre spécifique

            echo "\nEntrez le nom du livre :\n";
            $nom = trim(fgets(STDIN));
            $bibliotheque->displayBook($nom);
            break;
        case '6':
            // Logique de tri des livres
            echo "Choisissez la colonne pour le tri :\n";
            echo "1. Nom\n";
            echo "2. Description\n";
            echo "3. Stock\n";
            echo "4. ID\n"; // Ajout de l'option de tri par ID
            $columnChoice = trim(fgets(STDIN));

            switch ($columnChoice) {
                case '1':
                    $column = 'name';
                    break;
                case '2':
                    $column = 'description';
                    break;
                case '3':
                    $column = 'inStock';
                    break;
                case '4':
                    $column = 'id';
                    break;
                default:
                    echo "Option non valide.\n";
            }

            echo "Choisissez l'ordre du tri :\n";
            echo "1. Ascendant\n";
            echo "2. Descendant\n";
            $orderChoice = trim(fgets(STDIN));
            $order = ($orderChoice === '2') ? 'desc' : 'asc';

            $bibliotheque->sortBooks($column, $order);
            break;
        case '7':
            // Logique de recherche de livre

            // Choix de la colonnes
            echo "\nRechercher par :\n";
            echo "1. Nom\n";
            echo "2. Description\n";
            echo "3. ID\n";
            echo "Choisissez une option : ";
            $column = trim(fgets(STDIN));

            // faire un switch pour les colonnes
            switch ($column) {
                case '1':
                    $column = 'name';
                    echo "\nEntrez le nom du livre à rechercher :\n";
                    $bookData = trim(fgets(STDIN));
                    break;
                case '2':
                    $column = 'description';
                    echo "\nEntrez la description du livre à rechercher :\n";
                    $bookData = trim(fgets(STDIN));
                    break;
                case '3':
                    $column = 'id';
                    echo "\nEntrez l'id du livre à rechercher :\n";
                    $bookData = trim(fgets(STDIN));
                    break;
                default:
                    echo "Option non valide. Veuillez réessayer.\n";
            }

            $bibliotheque->findBook($column, $bookData);
            break;
        case '8':
            echo "C'est ciaooo !\n";
            $continuer = false;
            break;
        default:
            echo "Option non valide. Veuillez réessayer.\n";
    }
} while ($continuer);
