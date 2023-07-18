<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Amélie Nothomb - Écrivaine</title>
</head>
<body>
    <h1>Amélie Nothomb - Écrivaine</h1>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "mylibrary");
    if (!$conn) {
        die("Échec de la connexion à la base de données: " . mysqli_connect_error());
    }
    
    $sql_author = "SELECT * FROM authors WHERE firstname = 'Amelie' AND lastname = 'Nothomb'";
    $result_author = $conn->query($sql_author);

    if ($result_author->num_rows > 0) {
        $author = $result_author->fetch_assoc();
        echo "<h2>" . $author['firstname'] . " " . $author['lastname'] . "</h2>";
        echo "<p>Naissance: " . $author['birth_place'] . "</p>";
        echo "<p>Amélie Nothomb, nom de plume de Fabienne Claire Nothomb, est une romancière belge d'expression française
        née le 9 juillet 1966 à Etterbeek en Belgique.<br> 
        Auteur prolifique, elle publie un ouvrage par an depuis son premier roman,
        Hygiène de l'assassin.</p>";

        echo '<a href="https://fr.wikipedia.org/wiki/Am%C3%A9lie_Nothomb">Pour en savoir plus d\'Amélie Nothomb</a><br>';
    }

    // Afficher la photo de l'écrivaine Amélie Nothomb
    echo '<img src="image/Amélie_Nothomb.jpg" alt="">';
    echo '<form action="" method="post">';
    echo '<label for="livres">Choisissez un livre:</label>';
    echo '<select id="livres" name="livre">';
    
    $sql_books = "SELECT * FROM books WHERE author_id = " . $author['id'];
    $result_books = $conn->query($sql_books);

    if ($result_books->num_rows > 0) {
        while ($book = $result_books->fetch_assoc()) {
            echo '<option value="' . $book['id'] . '">' . $book['title'] . '</option>';
        }
    }

    echo '</select>';
    echo '<input type="submit" value="Afficher">';
    echo '</form>';

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
    <form action="index.php" method="get">
        <input type="submit" value="Retour Accueil">
    </form>
    <?php include "footer"?>;
