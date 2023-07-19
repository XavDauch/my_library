<!DOCTYPE html>
<?php
include "header.php";
include "db_connect.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyLibrary</title>
</head>

<body>
    <h1>Plaisir de lire</h1>
    <?php
    $query = "SELECT * FROM authors";
    $stmt = $pdo->query($query);
    $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["authors_id"])) {
        $authorsId = $_POST["authors_id"];

        // Requête pour obtenir les informations complètes de l'auteur sélectionné
        $query = "SELECT * FROM authors WHERE id = :authors_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':authors_id', $authorsId, PDO::PARAM_INT);
        $stmt->execute();
        $selectedAuthor = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <form action="" method="post">
        <label for="authors_select">Sélectionner un auteur à afficher :</label>
        <select name="authors_id" id="authors_select">
            <?php foreach ($authors as $author) : ?>
                <option value="<?= $author["id"] ?>"><?= $author["firstname"] . " " . $author["lastname"] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Afficher">
    </form>

    <?php
    if (isset($selectedAuthor)) {
        echo "<div class='author-container'>";
        echo "<div class='author-info'>";
        echo "<span class='label'>Prénom:</span>";
        echo "<p>" . $selectedAuthor["firstname"] . "</p>";
        echo "</div>";

        echo "<div class='author-info'>";
        echo "<span class='label'>Nom:</span>";
        echo "<p>" . $selectedAuthor["lastname"] . "</p>";
        echo "</div>";

        echo "<div class='author-info'>";
        echo "<span class='label'>Lieu de naissance:</span>";
        echo "<p>" . $selectedAuthor["birth_place"] . "</p>";
        echo "</div>";

        echo "<div class='author-info'>";
        echo "<span class='label'>Date de naissance:</span>";
        echo "<p>" . $selectedAuthor["birth_date"] . "</p>";
        echo "</div>";

        echo "<div class='author-info'>";
        echo "<span class='label'>Lien Wiki:</span>";
        echo "<p>" . $selectedAuthor["link_wiki"] . "</p>";
        echo "</div>";

        echo "<div class='author-info'>";
        echo "<span class='label'>Biographie:</span>";
        echo "<p>" . $selectedAuthor["biographie"] . "</p>";
        echo "</div>";

        echo "</div>"; // Fin du conteneur de l'auteur

        echo "<hr>";

        // Formulaire de suppression avec confirmation
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='author_id' value='" . $selectedAuthor["id"] . "'>";
        echo "<input type='submit' value='Supprimer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet auteur ?\")'>";
        echo "</form>";
    }
    ?>

    <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </form>
    <?php include "footer"; ?>
</body>

</html>
