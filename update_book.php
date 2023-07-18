<?php
// update_book.php

$conn = mysqli_connect("localhost", "root", "", "mylibrary");
if (!$conn) {
    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST["titre"];
    $auteur = $_POST["auteur"];
    $publication = $_POST["publication"];
    $traduit = isset($_POST["traduit"]) ? 1 : 0;
    $genre = $_POST["genre"];
    $librairie = $_POST["librairie"];

    $sql = "UPDATE books SET author = '$auteur', publication = '$publication', translate = '$traduit', genre = '$genre', library = '$librairie' WHERE title = '$titre'";

    if (mysqli_query($conn, $sql)) {
        $message = "Le livre a été modifié avec succès.";
    } else {
        $erreur = "Erreur lors de la modification du livre : " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
