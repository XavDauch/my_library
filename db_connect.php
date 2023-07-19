<?php

define('DSN', 'mysql:host=localhost;dbname=mylibrary');
define('USER', 'root');
define('PASS', '');

// creer un objet permettant une connexion à la B.D. 
$pdo = new \PDO(DSN, USER, PASS);

?>

