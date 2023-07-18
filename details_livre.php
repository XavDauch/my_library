<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Book Details</title>
    </head>
    <body>
        <?php      
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        // Step 3: Retrieve book information based on book ID
        if (isset($_GET['id'])) {
            $book_id = $_GET['id'];

            $sql = "SELECT books.id, title, publication.year, category, CONCAT(firstname, ' ', lastname) AS author_name, name AS library_name
                    FROM books
                    INNER JOIN authors ON books.author_id = authors.id
                    INNER JOIN book_genres ON books.category_id = book_genres.id
                    INNER JOIN books_library ON books.id = books_library.book_id
                    INNER JOIN library ON books_library.library_id = library.id
                    INNER JOIN publication ON books.publication = publication.id
                    WHERE books.id = $book_id";
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display book details
                $row = $result->fetch_assoc();
                echo "<h1>{$row['title']}</h1>";
                echo "<p>Publication Year: {$row['year']}</p>";
                echo "<p>Category: {$row['category']}</p>";
                echo "<p>Author: {$row['author_name']}</p>";
                echo "<p>Library: {$row['library_name']}</p>";
            } else {
                echo "Book not found.";
            }

            // Close the database connection
            $conn->close();
        } 
            else {
            echo "Invalid book ID.";
        }
        ?>
        <form action="index.php" method="get">
            <input type="submit" value="Retour Accueil">
        </form>
<?php include "footer"?>;
