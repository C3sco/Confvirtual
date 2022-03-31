<?php
    session_start();

    require '../../vendor/autoload.php';
    require_once("database.php");
    $dbh = new DatabaseHelper("localhost", "root", "", "confvirtual", 3306);
    //$dbh = new DatabaseHelper("localhost", "root", "root", "CONFVIRTUAL", 8889);

    try{
        $conn = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $conn->myDb->log;
    } catch (Exception $check){
        die ('Error msg: '. $check->getMessage());
    }
 
    $templateParams['LOGS']=$dbh->getLogs();
    
    foreach($templateParams['LOGS'] as $logs): 
        try{
            $collection->insertOne([
                '_id' => $logs['Id'],
                'Utente' =>  $logs['Utente'],
                'Operazione' =>  $logs['Operazione'],
                'Tabella' =>  $logs['Tabella'],
                'Orario' => $logs['Orario']],
            );
        } catch(Exception $err){
            $err->getMessage();
        }
    endforeach;    
?>
