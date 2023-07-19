<?php
include "header.php";
include "db_connect.php";

    $sql = "SELECT DISTINCT category FROM book_genres";

    // Exécuter la requête et récupérer les résultats
    $result = $conn->query($sql);

    // Vérifier s'il y a des résultats
    if ($result->rowCount() > 0) {
        // Créer une liste à puces pour afficher les catégories
        echo "<ul>";
        foreach ($result as $row) {
            echo "<li>" . $row['category'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune catégorie trouvée dans la table book_genres.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermer la connexion à la base de données
$conn = null;
?>

