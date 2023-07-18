<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter un livre</title>
        <style>
            label {
                display: block;
                margin-top: 10px;
            }
        </style>
        <h1>Ajouter un livre</h1>
    </head>

    <body>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        $confirmationMessage = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $authorFirstName = $_POST['author_firstname'];
            $authorLastName = $_POST['author_lastname'];
            $authorBirthPlace = $_POST['author_birth_place'];
            $publication = $_POST['publication'];
            $category = $_POST['category'];
            $translate = $_POST['translate'];
            $library = $_POST['library'];

            $queryBooks = "INSERT INTO books (title) VALUES ('$title')";
            $resultBooks = mysqli_query($conn, $queryBooks);

            $bookId = mysqli_insert_id($conn);

            $queryAuthors = "INSERT INTO authors (firstname, lastname, birth_place) VALUES ('$authorFirstName', '$authorLastName', '$authorBirthPlace')";
            $resultAuthors = mysqli_query($conn, $queryAuthors);

            $authorId = mysqli_insert_id($conn);

            $queryPublications = "INSERT INTO publication (year) VALUES ('$publication')";
            $resultPublications = mysqli_query($conn, $queryPublications);

            $publicationId = mysqli_insert_id($conn);

            $queryCategory = "SELECT id FROM book_genres WHERE category = '$category'";
            $resultCategory = mysqli_query($conn, $queryCategory);
            if (mysqli_num_rows($resultCategory) > 0) {
                $row = mysqli_fetch_assoc($resultCategory);
                $categoryId = $row['id'];
            } else {
                $queryInsertCategory = "INSERT INTO book_genres (category) VALUES ('$category')";
                mysqli_query($conn, $queryInsertCategory);
                $categoryId = mysqli_insert_id($conn);
            }

            $queryTranslate = "INSERT INTO `translate` (translate) VALUES ('$translate')";
            $resultTranslate = mysqli_query($conn, $queryTranslate);

            $translateId = mysqli_insert_id($conn);

            $queryLibrary = "SELECT id FROM library WHERE name = '$library'";
            $resultLibrary = mysqli_query($conn, $queryLibrary);
            if (mysqli_num_rows($resultLibrary) > 0) {
                $row = mysqli_fetch_assoc($resultLibrary);
                $libraryId = $row['id'];
            } else {
                $queryInsertLibrary = "INSERT INTO library (name) VALUES ('$library')";
                mysqli_query($conn, $queryInsertLibrary);
                $libraryId = mysqli_insert_id($conn);
            }
            if ($resultBooks && $resultAuthors && $resultPublications && $resultTranslate) {
                // Link the book to the library
                $queryBooksLibrary = "INSERT INTO books_library (book_id, library_id) VALUES ('$bookId', '$libraryId')";
                mysqli_query($conn, $queryBooksLibrary);

                $confirmationMessage = "Le livre a été ajouté avec succès!";
            } else {
                $confirmationMessage = "Une erreur s'est produite lors de l'ajout du livre.";
            }
        }
        ?>
        <?php if (!empty($confirmationMessage)) : ?>
            <p><?php echo $confirmationMessage; ?></p>
            <a href="index.php">Retour</a>
        <?php else : ?>
            <form action="" method="POST">
                <label for="title">Titre:</label>
                <input type="text" name="title" id="title" required minlength="2" maxlength="20" size="10">
                <br>

                <label for="author_firstname">Prénom de l'auteur:</label>
                <input type="text" name="author_firstname" id="author_firstname" required minlength="2" maxlength="20" size="10">
                <br>

                <label for="author_lastname">Nom de l'auteur:</label>
                <input type="text" name="author_lastname" id="author_lastname" required minlength="2" maxlength="20" size="10">
                <br>

                <label for="author_birth_place">Lieu de naissance de l'auteur:</label>
                <input type="text" name="author_birth_place" id="author_birth_place" required minlength="2" maxlength="20" size="10">
                <br>

                <label for="publication">Publication:</label>
                <input type="text" name="publication" id="publication" required minlength="2" maxlength="20" size="10">
                    <?php
                $queryPublications = "SELECT * FROM publication";
                $resultPublications = mysqli_query($conn, $queryPublications);

                if (mysqli_num_rows($resultPublications) > 0) {
                    while ($row = mysqli_fetch_assoc($resultPublications)) {
                            echo "<option value='" . $row['year'] . "'>" . $row['year'] . "</option>";
                    }
                    }
                ?>
                </select>
                <br>

                <label for="category">Catégorie:</label>
                <select name="category" id="category" required>
                    <?php
                    $queryCategories = "SELECT * FROM book_genres";
                    $resultCategories = mysqli_query($conn, $queryCategories);

                    if (mysqli_num_rows($resultCategories) > 0) {
                        while ($row = mysqli_fetch_assoc($resultCategories)) {
                            echo "<option value='" . $row['category'] . "'>" . $row['category'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <br>

                <label for="translate">Traduit:</label>
                <select name="translate" id="translate" required>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
                <br>

                <label for="library">Bibliothèque:</label>
                <select name="library" id="library" required>
                    <?php
                    $queryLibraries = "SELECT * FROM library";
                    $resultLibraries = mysqli_query($conn, $queryLibraries);

                    if (mysqli_num_rows($resultLibraries) > 0) {
                        while ($row = mysqli_fetch_assoc($resultLibraries)) {
                            echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <br><br>

                <input type="submit" value="Ajouter">
                <form action="index.php" method="get">
                <input type="submit" value="Retour Accueil">
            </form>
        <?php endif; ?>
<?php include "footer"?>;
