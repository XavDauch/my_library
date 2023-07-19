<?php
include "header.php";
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
       if (!empty($_POST["category"])) {
         $category = $_POST["category"];

        $sql = "INSERT INTO book_genres (category) VALUES (:category)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":category", $category, PDO::PARAM_STR);
            $stmt->execute();

            echo "La catégorie a été ajoutée avec succès.";
              echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez entrer une catégorie.";
    }

?>
<?php include "footer"?>;