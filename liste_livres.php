<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ma bibliothèque</title>
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
        <h1>Livres</h1>
        <?php
        $link = mysqli_connect('localhost', 'root', '', 'mylibrary');

        if (!$link) {
            echo "PROBLEM";
        } else {
            $result = mysqli_query($link, "SELECT books.id AS book_id, title, firstname, lastname, category, name, publication FROM books 
                                        JOIN authors ON books.author_id = authors.id
                                        JOIN book_genres ON books.category_id = book_genres.id
                                        JOIN library ON books.library_id = library.id
                                        ORDER BY title ASC");

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Title</th>';
                echo '<th>Author</th>';
                echo '<th>Category</th>';
                echo '<th>Library</th>';
                echo '<th>Publication</th>';
                echo '</tr>';

                while ($book = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $book["book_id"] . '</td>'; // Afficher l'ID du livre
                    echo '<td>' . $book["title"] . '</td>';
                    echo '<td>' . $book["firstname"] . ' ' . $book["lastname"] . '</td>';
                    echo '<td>' . $book["category"] . '</td>';
                    echo '<td>' . $book["name"] . '</td>';
                    echo '<td>' . $book["publication"] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'No books found.';
            }
        }

        mysqli_close($link);
        ?>
        <form action="index.php">
        <input type="submit" value="Retour accueil" />

<?php include "footer"?>;
