<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque - Recherche par auteur</title>
</head>
<body>
    <h1>Recherche par auteur</h1>
    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="auteur">Auteur :</label>
        <select name="auteur" id="auteur">
            <option value="">Sélectionner un auteur</option>
            <?php
            // Connexion à la base de données
            $conn = mysqli_connect("localhost", "root", "", "mylibrary");
            if (!$conn) {
                die("Échec de la connexion à la base de données: " . mysqli_connect_error());
            }

            // Récupérer les noms d'auteurs depuis la base de données
            $query = "SELECT * FROM authors";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id']}'>{$row['firstname']} {$row['lastname']}</option>";
            }

            // Fermer la connexion à la base de données
            mysqli_close($conn);
            ?>
        </select>
        <br>
        <input type="submit" value="Rechercher">
    </form>

    <?php
    // Vérifier si le formulaire a été soumis
    if (isset($_GET['auteur'])) {
        // Récupérer l'auteur sélectionné dans le menu déroulant
        $auteurId = $_GET['auteur'];

        $conn = mysqli_connect("localhost", "root", "", "mylibrary");
        if (!$conn) {
            die("Échec de la connexion à la base de données: " . mysqli_connect_error());
        }

        // Échapper la variable pour éviter les injections SQL
        $auteurId = mysqli_real_escape_string($conn, $auteurId);

        // Effectuer la requête SQL pour trouver les livres correspondants
        $query = "SELECT books.title, authors.firstname, authors.lastname, publication.year, library.name 
                    FROM books
                    INNER JOIN authors ON books.author_id = authors.id
                    INNER JOIN publication ON books.publication_id = publication.id
                    INNER JOIN books_library ON books.id = books_library.book_id
                    INNER JOIN library ON books_library.library_id = library.id
                    WHERE authors.id = '$auteurId'";

        $result = mysqli_query($conn, $query);

        // Vérifier s'il y a des résultats
        if (mysqli_num_rows($result) > 0) {
            // Afficher les résultats
            echo "<h2>Résultats de la recherche :</h2>";
            echo "<table>";
            echo "<tr><th>Titre</th><th>Auteur</th><th>Année de publication</th><th>Bibliothèque</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['title'] . "</td>";
                echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                echo "<td>" . $row['year'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Aucun livre trouvé pour cet auteur.";
        }
    }
        // Fermer la connexion à la base de données
        ?>
        <form action="index.php">
            <input type="submit" value="Retour accueil" />
        </form>   
<?php include "footer"?>;>
