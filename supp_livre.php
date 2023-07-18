<!DOCTYPE html>
<html>
<head>
    <title>Supprimer un livre</title>
</head>
<body>
    <h2>Supprimer un livre</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="titre">Titre :</label>
        <select name="titre" id="titre" required>
            <option value="">Sélectionnez un titre</option>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "mylibrary");
            if (!$conn) {
                die("Échec de la connexion à la base de données: " . mysqli_connect_error());
            }

            $sql = "SELECT id, title FROM books ORDER BY title ASC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["id"];
                    $title = $row["title"];
                    echo "<option value=\"$id\">$title</option>";
                }
            }

            mysqli_close($conn);
            ?>
        </select><br><br>
        <input type="submit" value="Supprimer le livre">
    </form>

    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titreId = $_POST["titre"];

        // Récupérer les informations du livre
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        $selectSql = "SELECT title FROM books WHERE id = $titreId";
        $result = mysqli_query($conn, $selectSql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $titre = $row["title"];

            // Afficher le message de confirmation
            echo "<p>Voulez-vous vraiment supprimer le livre suivant ?</p>";
            echo "<p><strong>Titre :</strong> $titre</p>";

            // Formulaire de confirmation
            echo "<form method=\"post\" action=\"{$_SERVER["PHP_SELF"]}\">";
            echo "<input type=\"hidden\" name=\"titre\" value=\"$titreId\">";
            echo "<input type=\"hidden\" name=\"confirm\" value=\"1\">";
            echo "<input type=\"submit\" value=\"Confirmer la suppression\">";
            echo "</form>";
        } else {
            $erreur = "Le livre avec l'ID \"$titreId\" n'a pas été trouvé.";
        }

        mysqli_close($conn);
    }

    // Vérifier si le formulaire de confirmation a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"])) {
        $titreId = $_POST["titre"];

        // Supprimer le livre de la base de données
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        $deleteSql = "DELETE FROM books WHERE id = $titreId";
        if (mysqli_query($conn, $deleteSql)) {
            $message = "Le livre avec l'ID \"$titreId\" a été supprimé avec succès.";
        } else {
            $erreur = "Erreur lors de la suppression du livre : " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }

    // Affichage du message de confirmation ou d'erreur
    if (isset($message)) {
        echo "<p>$message</p>";
    } elseif (isset($erreur)) {
        echo "<p>$erreur</p>";
    }
    ?>

    <form action="index.php" method="get">
        <input type="submit" value="Retour Accueil">
    </form>

</body>
</html>
