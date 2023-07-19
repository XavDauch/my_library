<!DOCTYPE html>
<?php
include "header<.php";
include "db_connect.php"
?>
<html>
<head>
    <title>Liste des auteurs</title>
</head>
<body>
    <h1>Nos auteurs</h1>
   <?php $query= "SELECT * FROM authors";
   $statement = $pdo->query($query);
   $livres = $statement->fetchAll(PDO::FETCH_ASSOC);?>
   
    <form action="index.php" method="get">;
        <input type="submit" value="Retour Accueil">;
    </form>
<?php include "footer.php"; ?>
