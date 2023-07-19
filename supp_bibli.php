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
$query = "SELECT * FROM library";
$stmt = $pdo->query($query);
$libraries = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["library_id"])) {
    $libraryId = $_POST["library_id"];

    // Requête pour obtenir les informations complètes de la bibliothèque sélectionnée
    $query = "SELECT * FROM library WHERE id = :library_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':library_id', $libraryId, PDO::PARAM_INT);
    $stmt->execute();
    $selectedLibrary = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<form action="" method="post">
    <label for="library_select">Sélectionner une bibliothèque à afficher :</label>
    <select name="library_id" id="library_select">
        <?php foreach ($libraries as $library) : ?>
            <option value="<?= $library["id"] ?>"><?= $library["name"] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Afficher">
</form>

<?php

if (isset($selectedLibrary)) {
    echo "<div class='library-container'>";
    echo "<div class='library-info'>";
    echo "<span class='label'>Nom:</span>";
    echo "<p>" . $selectedLibrary["name"] . "</p>";
    echo "</div>";

    echo "<div class='library-info'>";
    echo "<span class='label'>Adresse:</span>";
    echo "<div class='address-box'>";
    echo "<p>" . $selectedLibrary["address"] . "</p>";
    echo "</div>";
    echo "</div>";

    echo "<div class='library-info'>";
    echo "<span class='label'>Code postal:</span>";
    echo "<p>" . $selectedLibrary["location"] . "</p>";
    echo "</div>";

    echo "<div class='library-info'>";
    echo "<span class='label'>Accès PMR:</span>";
    echo "<p class='pmr-access'>" . ($selectedLibrary["pmr_access"] == 1 ? "Oui" : "Non") . "</p>";
    echo "</div>";

    echo "</div>"; // Fin du conteneur de la bibliothèque

    echo "<hr>";

    // Formulaire de suppression avec confirmation
    echo "<form action='' method='post'>";
    echo "<input type='hidden' name='library_id' value='" . $selectedLibrary["id"] . "'>";
    echo "<input type='submit' value='Supprimer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette bibliothèque ?\")'>";
    echo "</form>";
}
?>;

<form action="index.php">
    <input type="submit" value="Retour accueil" />
</form>
<?php include "footer"; ?>
