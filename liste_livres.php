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
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Liste complète des livres</h1>

    <?php
    $query = "SELECT books.*, authors.firstname as authors_firstname, authors.lastname as authors_lastname, publication.year, library.name AS library_name, book_genres.category
              FROM books
              INNER JOIN authors ON authors.id = books.author_id
              INNER JOIN publication ON publication.id = books.publication
              INNER JOIN books_library ON books.id = books_library.book_id
              INNER JOIN library ON books_library.library_id = library.id
              INNER JOIN book_genres ON books.category_id = book_genres.id";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($books) > 0) {
        echo "<table>";
        echo "<tr><th>Titre</th><th>Auteur</th><th>Année de publication</th><th>Bibliothèque</th><th>Catégorie</th></tr>";

        foreach ($books as $book) {
            echo "<tr>";
            echo "<td>" . $book['title'] . "</td>";
            echo "<td>" . $book['authors_firstname'] . " " . $book['authors_lastname'] . "</td>";
            echo "<td>" . $book['year'] . "</td>";
            echo "<td>" . $book['library_name'] . "</td>";
            echo "<td>" . $book['category'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun livre trouvé.";
    }
    ?>

    <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </form>

<?php
include "footer.php";
?>
