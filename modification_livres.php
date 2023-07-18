<!DOCTYPE html>
<html>
    <head>
        <title>Ma bibliothèque</title>
    </head>
    <body>
        <h1>Modifier un livre</h1>
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'mylibrary');
        if (!$conn) {
            die("La connexion à la base de données a échoué: " . mysqli_connect_error());
        }

        $query = "SELECT id, title FROM books";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Erreur lors de l'exécution de la requête: " . mysqli_error($conn));
        }

        echo '<form action="details_livre.php" method="post">';
        echo '<label for="livre">Sélectionnez un livre:</label>';
        echo '<select name="livre" id="livre">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="Afficher les détails">';
        echo '</form>';

        // Fermer la connexion à la base de données
        mysqli_close($conn);
        ?>
        <form action="index.php">
            <input type="submit" value="Retour accueil" />
        </form>
        
<?php include "footer"?>;
