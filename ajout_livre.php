<!DOCTYPE html>
<?php
include "header.php";
include "db_connect.php";

// Fonction pour insérer un nouvel auteur et retourner l'ID
function insertAuthorAndGetId($pdo, $firstname, $lastname, $birth_place)
{
    $query = "INSERT INTO authors (firstname, lastname, birth_place) VALUES (:firstname, :lastname, :birth_place)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':birth_place', $birth_place);
    $stmt->execute();
    return $pdo->lastInsertId();
}

// Fonction pour insérer une nouvelle catégorie et retourner l'ID
function insertCategoryAndGetId($pdo, $category)
{
    $query = "INSERT INTO book_genres (category) VALUES (:category)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':category', $category);
    $stmt->execute();
    return $pdo->lastInsertId();
}

// Fonction pour insérer une nouvelle bibliothèque et retourner l'ID
function insertLibraryAndGetId($pdo, $library)
{
    $query = "INSERT INTO library (name) VALUES (:library)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':library', $library);
    $stmt->execute();
    return $pdo->lastInsertId();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $title = $_POST['title'];
    $authorFirstName = $_POST['author_firstname'];
    $authorLastName = $_POST['author_lastname'];
    $authorBirthPlace = $_POST['author_birth_place'];
    $publication = $_POST['publication'];
    $category = $_POST['category'];
    $translate = $_POST['translate'];
    $library = $_POST['library'];

    try {
        // Commencer la transaction
        $pdo->beginTransaction();

        // Insérer l'auteur et récupérer l'ID
        $authorId = insertAuthorAndGetId($pdo, $authorFirstName, $authorLastName, $authorBirthPlace);

        // Insérer le livre
        $queryBooks = "INSERT INTO books (title, author_id, publication_id, category_id, translate_id) VALUES (:title, :author_id, :publication_id, :category_id, :translate_id)";
        $stmt = $pdo->prepare($queryBooks);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author_id', $authorId);
        $stmt->bindParam(':publication_id', $publication);
        $stmt->bindParam(':category_id', $category);
        $stmt->bindParam(':translate_id', $translate);
        $stmt->execute();

        // Récupérer l'ID du livre inséré
        $bookId = $pdo->lastInsertId();

        // Vérifier si la bibliothèque existe déjà
        $queryLibrary = "SELECT id FROM library WHERE name = :library";
        $stmt = $pdo->prepare($queryLibrary);
        $stmt->bindParam(':library', $library);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // La bibliothèque existe, récupérer son ID
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $libraryId = $row['id'];
        } else {
            // La bibliothèque n'existe pas, l'insérer et récupérer son ID
            $libraryId = insertLibraryAndGetId($pdo, $library);
        }

        // Lier le livre à la bibliothèque
        $queryBooksLibrary = "INSERT INTO books_library (book_id, library_id) VALUES (:book_id, :library_id)";
        $stmt = $pdo->prepare($queryBooksLibrary);
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':library_id', $libraryId);
        $stmt->execute();

        // Valider la transaction
        $pdo->commit();

        $confirmationMessage = "Le livre a été ajouté avec succès!";
    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction
        $pdo->rollBack();
        $confirmationMessage = "Une erreur s'est produite lors de l'ajout du livre.";
    }
}
?>
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
            <br>

            <label for="category">Catégorie:</label>
            <select name="category" id="category" required>
                <?php
                $queryCategories = "SELECT * FROM book_genres";
                $stmt = $pdo->query($queryCategories);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['category'] . "</option>";
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
                $stmt = $pdo->query($queryLibraries);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <br><br>

            <input type="submit" value="Ajouter">
        </form>
        <form action="index.php" method="get">
            <input type="submit" value="Retour Accueil">
        </form>
    <?php endif; ?>
    <?php include "footer"; ?>
</body>

</html>

