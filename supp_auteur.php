<!DOCTYPE html>
<html>
<head>
    <title>Supprimer un auteur</title>
</head>
<body>
    <h2>Supprimer un auteur</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="author">Auteur :</label>
        <select name="author" id="author" required>
            <option value="">Sélectionnez un auteur</option>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "mylibrary");
            if (!$conn) {
                die("Échec de la connexion à la base de données: " . mysqli_connect_error());
            }

            $sql = "SELECT id, firstname, lastname FROM authors ORDER BY lastname ASC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $authorId = $row["id"];
                    $firstname = $row["firstname"];
                    $lastname = $row["lastname"];
                    echo "<option value=\"$authorId\">$firstname $lastname</option>";
                }
            }

            mysqli_close($conn);
            ?>
        </select><br><br>
        <input type="submit" value="Supprimer l'auteur">
    </form>

    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        $authorId = $_POST["author"];
        if (!empty($authorId)) {
            $selectSql = "SELECT firstname, lastname, birth_place FROM authors WHERE id = $authorId";
            $result = mysqli_query($conn, $selectSql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $birthPlace = $row["birth_place"];

                // Afficher le message de confirmation
                echo "<p>Voulez-vous vraiment supprimer l'auteur suivant ?</p>";
                echo "<p><strong>Nom :</strong> $firstname $lastname</p>";
                echo "<p><strong>Lieu de naissance :</strong> $birthPlace</p>";
                echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
                echo '<input type="hidden" name="authorId" value="' . $authorId . '">';
                echo '<input type="hidden" name="confirm" value="1">';
                echo '<input type="submit" value="Confirmer la suppression">';
                echo '</form>';
            } else {
                $erreur = "L'auteur avec l'ID $authorId n'a pas été trouvé.";
            }
        }

        mysqli_close($conn);
    }
    ?>

    <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </form>
</body>
</html>
