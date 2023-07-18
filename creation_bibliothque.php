<?php
include "header<.php"
?>
    <head>
        <h1>Création Bibliothèque</h1>
        <style>
            label {
                display: block;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required minlength="2" maxlength="20" size="10">

            <label for="address">Adresse:</label>
            <input type="text" id="address" name="address" required minlength="2" maxlength="20" size="10">
            <br>

            <label for="location">Code postal:</label>
            <input type="int" id="location" name="location" required minlength="2" maxlength="8" size="10">
            <br>

            <label for="pmr_access">PMR Accès:</label>
            <input type="checkbox" id="pmr_access" name="pmr_access"><br>
            <br>
            <button type="submit">Ajouter</button>
            <button type="button" onclick="window.location.href='index.php'">Retour</button>
        </form>

            <?php
            // Vérifier si le formulaire a été soumis
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Récupérer les données du formulaire
                $name = $_POST["name"];
                $address = $_POST["address"];
                $location = $_POST["location"];
                $pmrAccess = isset($_POST["pmr_access"]) ? 1 : 0;

                $conn = mysqli_connect("localhost", "root", "", "mylibrary");
                if (!$conn) {
                    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
                }

                $sql = "INSERT INTO library (name, address, location, pmr_access) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $name, $address, $location, $pmrAccess);
                if ($stmt->execute()) {
                    echo "Library créée avec succès !";
                } else {
                    echo "Erreur lors de création de la library: " . $stmt->error;
                }

                // Fermer la connexion à la base de données
                $stmt->close();
                $conn->close();
            }
            ?>
<?php include "footer"?>;