<?php 
include "header.php";
include "db_connect.php";

// recuperation de l'identifiant dans l'url 
$id=$_GET['id'];
// $query="SELECT * FROM "nom de la atable" WHERE id=$id";

$query="SELECT * FROM books WHERE id=:monidprotege";

// on va preparer la requete
$statement = $pdo->prepare($query);
$statement->bindValue(':monidprotege', $id, \PDO::PARAM_INT);

// On utilise statement qui a une méthode (sa propre fonction) permettant
// de récupérer les données. On utilise le parametre PDO::FETCH_ASSOC
// qui nous permet d'avoir un format de donnée sous forme de tableau
// associatif
$statement->execute();
$unlivre = $statement->fetch(PDO::FETCH_ASSOC);
var_dump($unlivre);

/*
 $statement = $pdo->prepare($query);
$statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
$statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
$statement->execute();
$friends = $statement->fetchAll();
 */


// affiche "vous avez cliquez sur le livre n 1."
echo "Vous avez cliquez sur le livre n°".$unlivre['id'];

echo "<hr>titre : ".$unlivre['titre'];
  
 