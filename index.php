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
            // Logique de modification de livre
            break;
        case '3':
            // Logique de suppression de livre

            echo "\nComment voulez-vous supprimer le livre ?\n";
            echo "1. Par son nom\n";
            echo "2. Par son commentaire\n";
            echo "3. Par son id\n";
            echo "4. Retour\n";
            echo "Choisissez une option : ";
            $choixSuppression = trim(fgets(STDIN));

            switch ($choixSuppression) {
                case '1':
                    echo "\nEntrez le nom du livre à supprimer : ";
                    $nom = trim(fgets(STDIN));
                    $bibliotheque->deleteBook($nom, 'name');
                    break;
                case '2':
                    echo "\nEntrez le commentaire du livre à supprimer : ";
                    $description = trim(fgets(STDIN));
                    $bibliotheque->deleteBook($description, 'description');
                    break;
                case '3':
                    echo "\nEntrez l'id du livre à supprimer : ";
                    $id = trim(fgets(STDIN));
                    $bibliotheque->deleteBook($id, 'id');
                    break;
                case '4':
                    break;
                default:
                    echo "\nOption non valide. Veuillez réessayer.\n";
            }

            break;
        case '4':
            // Logique d'affichage de tous les livres
            break;
        case '5':
            // Logique d'affichage d'un livre spécifique

            echo "\nEntrez le nom du livre :\n";
            $nom = trim(fgets(STDIN));
            $bibliotheque->displayBook($nom);
            break;
        case '6':
            // Logique de tri des livres
            break;
        case '7':
            // Logique de recherche de livre
            break;
        case '8':
            echo "C'est chaooo !\n";
            $continuer = false;
            break;
        default:
            echo "Option non valide. Veuillez réessayer.\n";
    }
} while ($continuer);