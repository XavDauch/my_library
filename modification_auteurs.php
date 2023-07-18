<!DOCTYPE html>
<html>

    <head>
        <title>Modifier un auteur</title>
    </head>

    <body>
        <h2>Modifier un auteur</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="lastname">Nom :</label>
            <select name="lastname" required>
                <option value="">Sélectionner un nom d'auteur</option>
                <?php
                $conn = mysqli_connect("localhost", "root", "", "mylibrary");
                if (!$conn) {
                    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
                }

                $sql = "SELECT DISTINCT lastname FROM authors";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['lastname'] . "'";
                    if (isset($_POST['lastname']) && $_POST['lastname'] == $row['lastname']) {
                        echo " selected";
                    }
                    echo ">" . $row['lastname'] . "</option>";
                }

                mysqli_close($conn);
                ?>
            </select><br><br>

            <?php
                if (isset($_POST['lastname'])) {
                $selectedLastname = $_POST['lastname'];

                $conn = mysqli_connect("localhost", "root", "", "mylibrary");
                if (!$conn) {
                    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM authors WHERE lastname='$selectedLastname'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $firstname = $row['firstname'];
                    $birth_date = $row['birth_date'];
                    $birth_place = $row['birth_place'];
                    $biographie = $row['biographie'];
                    $link_wiki = $row['link_wiki'];

                    echo '<label for="firstname">Prénom :</label>';
                    echo '<input type="text" name="firstname" value="' . $firstname . '" required><br><br>';

                    echo '<label for="birth_date">Date de Naissance :</label>';
                    echo '<input type="text" name="birth_date" value="' . $birth_date . '" required><br><br>';

                    echo '<label for="birth_place">Pays de Naissance :</label>';
                    echo '<input type="text" name="birth_place" value="' . $birth_place . '" required><br><br>';

                    echo '<label for="biographie">Biographie :</label>';
                    echo '<input type="text" name="biographie" value="' . $biographie . '" required><br><br>';

                    echo '<label for="link_wiki">En savoir plus :</label>';
                    echo '<input type="text" name="link_wiki" value="' . $link_wiki . '" required><br><br>';
                } else {
                    echo 'Aucun auteur trouvé avec ce nom.';
                }

                mysqli_close($conn);
                }
            ?>

                <input type="submit" value="Modifier l'auteur">
            </form>
            <br>
            <form action="index.php">
                <input type="submit" value="Retour accueil" />
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lastname'])) {
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $birth_place = $_POST["birth_place"];
                $birth_date = $_POST["birth_date"];
                $link_wiki = $_POST["link_wiki"];
                $biographie = $_POST["biographie"];

                $conn = mysqli_connect("localhost", "root", "", "mylibrary");
                if (!$conn) {
                    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
                }

                $sql = "UPDATE authors SET firstname='$firstname', birth_date='$birth_date', birth_place='$birth_place', biographie='$biographie', link_wiki='$link_wiki' WHERE lastname='$lastname'";

                if (mysqli_query($conn, $sql)) {
                    echo "L'auteur a été modifié avec succès.";
                } else {
                    echo "Erreur lors de la modification de l'auteur : " . mysqli_error($conn);
                }

                mysqli_close($conn);
            }
            ?>

    
<?php include "footer.php"; ?>

