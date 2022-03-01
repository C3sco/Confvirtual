<?php

#$pdo=new PDO("mysql:host=localhost;dbname=CONFVIRTUAL","root","Sium.123");

session_start();
#define("UPLOAD_DIR", "../Immagini/");
#require_once("utils/function.php");
require_once("database.php");
$dbh = new DatabaseHelper("localhost", "root", "", "confvirtual",3306);





/*
try {$pdo=new PDO("mysql:host=localhost;dbname=CONFVIRTUAL","root","Sium.123");
}
catch(PDOException ex)    {    
    echo(“Connessione    non    riuscita”);    
    exit();    
}
#$pdo-­>setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
#$pdo->exec(‘SET NAMES “utf8”’); 




?>
*/
?>

