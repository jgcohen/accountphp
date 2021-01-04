<?php 

// Informations d'identification
$dsn = 'mysql:dbname=account;host=localhost';
$user = 'root';
$password = '';

try {
    //$bdd=new PDO("mysql: host=localhost; dbname=success","","");
      $pdo = new PDO($dsn, $user, $password);
}
catch( PDOException $Exception ) {
 ///Ca c'est l'exception si il arrive pas à se connecter à la base de donnée.   
    echo 'Échec lors de la connexion : '.$Exception->getMessage( );
}
/*Paramétrage de la liaison PHP <-> MySQL, les données sont encodées en UTF-8.*/
	$pdo->exec('SET NAMES UTF8');
?>