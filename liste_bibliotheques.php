<?php
include "header.php";
include "db_connect.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyLibrary</title>
    <style>
        /* Ajoutez le CSS ici */
        .library-container {
            background-color: grey;
            padding: 1px;
            margin-bottom: 1px;
        }

        .library-info {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 1px;
        }

        .label {
            font-weight: bold;
            margin-right: 3px;
        }

        .address-box {
            background-color: grey;
            padding: 1px;
            margin-bottom: 1px;
        }

        .pmr-access {
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Plaisir de lire</h1>
    <?php
    $query = "SELECT * FROM library";
    $stmt = $pdo->query($query);
    $libraries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($libraries as $library) {
        echo "<div class='library-container'>";
        echo "<div class='library-info'>";
        echo "<span class='label'>Nom:</span>";
        echo "<p>" . $library["name"] . "</p>";
        echo "</div>";

        echo "<div class='library-info'>";
        echo "<span class='label'>Adresse:</span>";
        echo "<div class='address-box'>";
        echo "<p>" . $library["address"] . "</p>";
        echo "</div>";
        echo "</div>";

        echo "<div class='library-info'>";
        echo "<span class='label'>Code postal:</span>";
        echo "<p>" . $library["location"] . "</p>";
        echo "</div>";

        echo "<div class='library-info'>";
        echo "<span class='label'>Accès PMR:</span>";
        echo "<p class='pmr-access'>" . ($library["pmr_access"] == 1 ? "Oui" : "Non") . "</p>";
        echo "</div>";

        echo "</div>"; // Fin du conteneur de la bibliothèque

        echo "<hr>";
    }
    ?>

    <form action="index.php">
        <input type="submit" value="Retour accueil" />
    </form>
    <?php include "footer"; ?>
</body>

</html>
