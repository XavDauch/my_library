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
        
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        $result = mysqli_query($conn, $query);

        // Vérifier s'il y a des résultats
        if (mysqli_num_rows($result) > 0) {
            // Afficher les résultats
            echo "<table>";
            echo "<tr><th>Titre</th><th>Auteur</th><th>Année de publication</th><th>Bibliothèque</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                echo "<td>" . $row['year'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Aucun livre trouvé.";
        }

        // Fermer la connexion à la base de données
        mysqli_close($conn);
        ?>

        <h1>Book</h1>
        <?php
        $link = mysqli_connect('localhost', 'root', '', 'mylibrary');

        if (!$link) {
            echo "PROBLEME";
        } else {
            $result = mysqli_query($link, "SELECT * FROM books");
            $id_authors = [];
            $id_categorys = [];
            $id_librarys = [];
            foreach ($result as $book) {
                echo $book["id"] . "<br>";
                echo $book["title"] . "<br>";
                array_push($id_authors, $book["author_id"]);
                array_push($id_categorys, $book["category_id"]);
                array_push($id_librarys, $book["library_id"]);
                echo $book["translate"] . "<br>";
                echo $book["library_id"] . "<br>";
                echo $book["publication"] . "<br>";
            }
        }

        for ($i = 0; $i < count($id_authors); $i++) {
            $result = mysqli_query($link, "SELECT * FROM `authors` WHERE id = '" . $id_authors[$i] . "'");
            foreach ($result as $author) {
                echo $author["firstname"] . "<br>";
                echo $author["lastname"] . "<br>";
                echo $author["birth_place"] . "<br>";
            }
        }

        for ($i = 0; $i < count($id_categorys); $i++) {
            $result = mysqli_query($link, "SELECT * FROM `book_genres` WHERE id = '" . $id_categorys[$i] . "'");
            foreach ($result as $category) {
                echo $category["category"] . "<br>";
            }

            for ($i = 0; $i < count($id_librarys); $i++) {
                $result = mysqli_query($link, "SELECT * FROM `library` WHERE id = '" . $id_librarys[$i] . "'");
                foreach ($result as $librarys) {
                    echo $librarys["name"] . "<br>";
                    echo $librarys["address"] . "<br>";
                    echo $librarys["location"] . "<br>";
                    echo $librarys["pmr_access"] . "<br>";
                }
            }
        }

        ?>
        <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </body>
</html>
