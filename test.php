<!DOCTYPE html>
<html>
    <head>
        <title>Ma Bibliothèque</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
            }

            h1 {
                margin-top: 40px;
            }

            ul {
                list-style: none;
                padding: 0;
                margin: 20px 0;
            }

            li {
                display: inline-block;
                margin-right: 10px;
            }

            li a {
                display: block;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                text-decoration: none;
                color: #333;
                background-color: #f9f9f9;
                transition: background-color 0.3s;
            }

            li a:hover {
                background-color: #ddd;
            }
        </style>
    </head>
    <body>
        <h1>Au plaisir de lire</h1>
        <ul>
            <li><a href="liste_livres.php">Livres</a></li>
            <li><a href="liste_auteurs.php">Auteurs</a></li>
            <li><a href="liste_genres.php">Genres</a></li>
            <li><a href="liste_bibliotheques.php">Bibliothèques</a></li>
            <li><a href="modification_livres.php">Gestion des livres</a></li>
        </ul>
        <form action="modification.php" method="post">
        </form>
        <?php include "footer"?>
    </body>
</html>
