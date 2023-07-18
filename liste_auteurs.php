<!DOCTYPE html>
<html>
<head>
    <title>Liste des auteurs</title>
</head>
<body>
    <h1>Nos auteurs</h1>
    <select onchange="navigateToAuthorPage(this)">
        <option value="">Sélectionnez un auteur</option>
        <?php
        $link = mysqli_connect('localhost', 'root', '', 'mylibrary');

        if (!$link) {
            echo "PROBLEME";
        } else {
            $result = mysqli_query($link, "SELECT * FROM authors");

            while ($author = mysqli_fetch_assoc($result)) {
                $fullName = $author["firstname"] . ' ' . $author["lastname"];
                $author_id = $author["id"];
                echo "<option value='detail_auteurs.php?id=$author_id'>$fullName</option>";
            }
        }
        mysqli_close($link);
        ?>
    </select>

    <script>
        function navigateToAuthorPage(select) {
            const selectedAuthor = select.value;
            if (selectedAuthor !== "") {
                window.location.href = selectedAuthor;
            }
        }
    </script>
    <form action="index.php" method="get">
        <input type="submit" value="Retour Accueil">
    </form>
<?php include "footer.php"; ?>
</body>
</html>
