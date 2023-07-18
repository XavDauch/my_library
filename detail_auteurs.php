<!DOCTYPE html>
<html>
<head>
    <title>Détails de l'auteur</title>
</head>
<body>
    <h1>Détails de l'auteur</h1>
    <?php
    if (isset($_GET['id'])) {
        $author_id = $_GET['id'];

        $link = mysqli_connect('localhost', 'root', '', 'mylibrary');

        if (!$link) {
            echo "PROBLEME";
        } else {
            $query = "SELECT * FROM authors WHERE id = '$author_id'";
            $result = mysqli_query($link, $query);

            if ($author = mysqli_fetch_assoc($result)) {
                echo "<p><strong>Nom :</strong> " . $author["firstname"] . " " . $author["lastname"] . "</p>";
                echo "<p><strong>Lieu de naissance :</strong> " . $author["birth_place"] . "</p>";
                echo "<p><strong>Date de naissance :</strong> " . $author["birth_date"] . "</p>";
                echo "<p><strong>Biographie :</strong> " . $author["biographie"] . "</p>";
                // Ajoutez d'autres détails de l'auteur si nécessaire
            } else {
                echo "<p>L'auteur sélectionné n'existe pas.</p>";
            }
        }
        mysqli_close($link);
    } else {
        echo "<p>Aucun auteur sélectionné.</p>";
    }
    ?>
    <form action="liste_auteurs.php" method="get">
        <input type="submit" value="Retour à la liste des auteurs">
    </form>
<?php include "footer.php"; ?>

