<!DOCTYPE html>
<html>
<head>
    <title>Supprimer une bibliothèque</title>
</head>
<body>
    <h2>Supprimer une bibliothèque</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Nom :</label>
        <select name="name" id="name" required>
            <option value="">Sélectionnez une bibliothèque</option>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "mylibrary");
            if (!$conn) {
                die("Échec de la connexion à la base de données: " . mysqli_connect_error());
            }

            $sql = "SELECT name, address, location FROM library ORDER BY name ASC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row["name"];
                    $address = $row["address"];
                    $location = $row["location"];
                    echo "<option value=\"$name\">$name</option>";
                }
            }

            mysqli_close($conn);
            ?>
        </select><br><br>
        <input type="submit" value="Supprimer la bibliothèque">
    </form>

    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];

        // Récupérer les informations de la bibliothèque
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        $selectSql = "SELECT name, address, location FROM library WHERE name = '$name'";
        $result = mysqli_query($conn, $selectSql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $address = $row["address"];
            $location = $row["location"];

            // Afficher le message de confirmation
            echo "<p>Voulez-vous vraiment supprimer la bibliothèque suivante ?</p>";
            echo "<p><strong>Nom :</strong> $name</p>";
            echo "<p><strong>Adresse :</strong> $address</p>";
            echo "<p><strong>Emplacement :</strong> $location</p>";

            // Formulaire de confirmation
            echo "<form method=\"post\" action=\"{$_SERVER["PHP_SELF"]}\">";
            echo "<input type=\"hidden\" name=\"name\" value=\"$name\">";
            echo "<input type=\"hidden\" name=\"confirm\" value=\"1\">";
            echo "<input type=\"submit\" value=\"Confirmer la suppression\">";
            echo "</form>";
           
        } else {
            $erreur = "La bibliothèque \"$name\" n'a pas été trouvée.";
        }

        mysqli_close($conn);
    }

    // Vérifier si le formulaire de confirmation a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"])) {
        $name = $_POST["name"];

        // Supprimer la bibliothèque de la base de données
        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        $deleteSql = "DELETE FROM library WHERE name = '$name'";
        if (mysqli_query($conn, $deleteSql)) {
            $message = "La bibliothèque \"$name\" a été supprimée avec succès.";
        } else {
            $erreur = "Erreur lors de la suppression de la bibliothèque : " . mysqli_error($conn);
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

    <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </form>
</body>
</html>

