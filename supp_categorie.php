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
    $query = "SELECT * FROM book_genres";
    $stmt = $pdo->query($query);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["category_id"])) {
        $categoryId = $_POST["category_id"];

        // Requête pour obtenir les informations complètes de la catégorie sélectionnée
        $query = "SELECT * FROM book_genres WHERE id = :category_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        $selectedCategory = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>

    <form action="" method="post">
        <label for="category_select">Sélectionner une catégorie à afficher :</label>
        <select name="category_id" id="category_select">
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category["id"] ?>"><?= $category["category"] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Afficher">
    </form>

    <?php
    if (isset($selectedCategory)) {
        echo "<div class='library-container'>";
        echo "<div class='library-info'>";
        echo "<span class='label'>Catégorie:</span>";
        echo "<p>" . $selectedCategory["category"] . "</p>";
        echo "</div>";

        echo "</div>"; // Fin du conteneur de la catégorie

        echo "<hr>";

        // Formulaire de suppression avec confirmation
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='category_id' value='" . $selectedCategory["id"] . "'>";
        echo "<input type='submit' value='Supprimer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette catégorie ?\")'>";
        echo "</form>";
    }
    ?>

    <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </form>
    <?php include "footer"; ?>
</body>

</html>
