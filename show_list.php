<?php
include "header.php";
include "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque - Liste complète des livres</title>
</head>
<body>
    <h1>Liste complète des livres</h1>

    <?php
    // Effectuer la requête SQL pour récupérer tous les livres
    $query = "SELECT books.title, authors.firstname, authors.lastname, publication.year, library.name 
            FROM books
            INNER JOIN authors ON books.author_id = authors.id
            INNER JOIN publication ON books.publication = publication.id
            INNER JOIN books_library ON books.id = books_library.book_id
            INNER JOIN library ON books_library.library_id = library.id";

    try {
        $stmt = $pdo->query($query);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier s'il y a des résultats
        if (count($books) > 0) {
            // Afficher les résultats dans un tableau
            echo "<table>";
            echo "<tr><th>Titre</th><th>Auteur</th><th>Année de publication</th><th>Bibliothèque</th></tr>";

            foreach ($books as $book) {
                echo "<tr>";
                echo "<td>" . $book['title'] . "</td>";
                echo "<td>" . $book['firstname'] . " " . $book['lastname'] . "</td>";
                echo "<td>" . $book['year'] . "</td>";
                echo "<td>" . $book['name'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Aucun livre trouvé.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
    ?>

    <h1>Book</h1>
    <?php
    try {
        $stmt = $pdo->query("SELECT * FROM books");
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $id_authors = [];
        $id_categorys = [];
        $id_librarys = [];

        foreach ($books as $book) {
            echo $book["id"] . "<br>";
            echo $book["title"] . "<br>";
            array_push($id_authors, $book["author_id"]);
            array_push($id_categorys, $book["category_id"]);
            array_push($id_librarys, $book["library_id"]);
            echo $book["translate"] . "<br>";
            echo $book["library_id"] . "<br>";
            echo $book["publication"] . "<br>";
        }

        for ($i = 0; $i < count($id_authors); $i++) {
            $stmt = $pdo->prepare("SELECT * FROM `authors` WHERE id = :author_id");
            $stmt->bindParam(':author_id', $id_authors[$i], PDO::PARAM_INT);
            $stmt->execute();
            $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($authors as $author) {
                echo $author["firstname"] . "<br>";
                echo $author["lastname"] . "<br>";
                echo $author["birth_place"] . "<br>";
            }
        }

        for ($i = 0; $i < count($id_categorys); $i++) {
            $stmt = $pdo->prepare("SELECT * FROM `book_genres` WHERE id = :category_id");
            $stmt->bindParam(':category_id', $id_categorys[$i], PDO::PARAM_INT);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($categories as $category) {
                echo $category["category"] . "<br>";
            }

            for ($i = 0; $i < count($id_librarys); $i++) {
                $stmt = $pdo->prepare("SELECT * FROM `library` WHERE id = :library_id");
                $stmt->bindParam(':library_id', $id_librarys[$i], PDO::PARAM_INT);
                $stmt->execute();
                $libraries = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($libraries as $library) {
                    echo $library["name"] . "<br>";
                    echo $library["address"] . "<br>";
                    echo $library["location"] . "<br>";
                    echo $library["pmr_access"] . "<br>";
                }
            }
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
    ?>

    <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </form>
</body>
</html>
