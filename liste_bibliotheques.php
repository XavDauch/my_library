<!DOCTYPE html>
<html lang="en">

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
        $link = mysqli_connect('localhost', 'root', '', 'mylibrary');

        if (!$link) {
            echo "PROBLEME";
        } else {
        $result = mysqli_query($link, "SELECT * FROM library");
        $id_librarys = [];
        foreach ($result as $library) {
            array_push($id_librarys, $library["library_id"]);

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
        for ($i = 0; $i < count($id_librarys); $i++) {
            $result = mysqli_query($link, "SELECT  `book_id` FROM `books_library` JOIN `books` ON 'book_id' = 'id' WHERE library_id = '" . $id_librarys[$i] . "'");
            foreach ($result as $librarys_Name) {
                echo $librarys_Name["book_id"] . "<br>";
            }
        }
        }
        ?>
        <form action="index.php">
            <input type="submit" value="Retour accueil" />
<?php include "footer"?>;
