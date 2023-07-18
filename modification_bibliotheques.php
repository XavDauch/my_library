<!DOCTYPE html>
<html>

    <head>
        <title>Modifier une bibliothèque</title>
    </head>
    <body>
        <h2>Modifier une bibliothèque</h2>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="name">Nom :</label>
            <select name="name" required onchange="this.form.submit()">
                <option value="">Sélectionner une bibliothèque</option>
                <?php
                $conn = mysqli_connect("localhost", "root", "", "mylibrary");
                if (!$conn) {
                    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
                }
                $sql = "SELECT DISTINCT name FROM library";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['name'] . "'";
                    if (isset($_POST['name']) && $_POST['name'] == $row['name']) {
                        echo " selected";
                    }
                    echo ">" . $row['name'] . "</option>";
                }

                mysqli_close($conn);
                ?>
            </select><br><br>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
                $name = $_POST["name"];

                $conn = mysqli_connect("localhost", "root", "", "mylibrary");
                if (!$conn) {
                    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM library WHERE name='$name'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    $name = $row['name'];
                    $address = $row['address'];
                    $location = $row['location'];
                    $pmr_access = $row['pmr_access'];

                    echo '<input type="hidden" name="library_id" value="' . $row['id'] . '">';

                    echo '<label for="name">Nom :</label>';
                    echo '<input type="text" name="new_name" value="' . $name . '" required><br><br>';

                    echo '<label for="address">Adresse :</label>';
                    echo '<input type="text" name="address" value="' . $address . '" required><br><br>';

                    echo '<label for="location">Code_postal :</label>';
                    echo '<input type="text" name="location" value="' . $location . '" required><br><br>';

                    echo '<label for="pmr_access">PMR_access :</label>';
                    echo '<input type="text" name="pmr_access" value="' . $pmr_access . '" required><br><br>';
                } else {
                    echo 'Aucune bibliothèque trouvée avec ce nom.';
                }

                mysqli_close($conn);
            }
            ?>
            <input type="submit" name="modify_library" value="Modifier la bibliothèque">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['library_id']) && isset($_POST['modify_library'])) {
                $library_id = $_POST["library_id"];
                $new_name = $_POST["new_name"];
                $address = $_POST["address"];
                $location = $_POST["location"];
                $pmr_access = $_POST["pmr_access"];

                $conn = mysqli_connect("localhost", "root", "", "mylibrary");
                if (!$conn) {
                    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
                }

                $sql = "UPDATE library SET name='$new_name', address='$address', location='$location', pmr_access='$pmr_access' WHERE id = $library_id";

                if (mysqli_query($conn, $sql)) {
                    echo "La bibliothèque a été modifiée avec succès.";
                } else {
                    echo "Erreur lors de la modification de la bibliothèque : " . mysqli_error($conn);
                }

                mysqli_close($conn);
            }
            ?>
            <br>
            <form action="index.php">
                <input type="submit" value="Retour accueil" />
            </form>
    
<?php include "footer"?>;
