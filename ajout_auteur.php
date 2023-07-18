<?php
include "header<.php"
?>
    <head>
        <title>Ajout Auteur</title>
        <style>
            label {
                display: block;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <h1>Ajout Auteur</h1>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="firstname">Prénom:</label>
            <input type="text" name="firstname" id="firstname" required><br>

            <label for="lastname">Nom:</label>
            <input type="text" name="lastname" id="lastname" required><br>

            <label for="birth_place">Pays de naissance:</label>
            <input type="text" name="birth_place" id="birth_place" required><br>
            <br>
            <input type="submit" value="Ajouter">
            <button type="button" onclick="window.location.href='index.php'">Retour</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $birth_place = $_POST["birth_place"];

            $conn = mysqli_connect("localhost", "root", "", "mylibrary");
            if (!$conn) {
                die("Échec de la connexion à la base de données: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO authors (firstname, lastname, birth_place) VALUES ('$firstname', '$lastname', '$birth_place')";

            if (mysqli_query($conn, $sql)) {
                echo "L'auteur a été ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout de l'auteur : " . mysqli_error($conn);
            }

            mysqli_close($conn);
        }
        ?>
<?php include "footer"?>;