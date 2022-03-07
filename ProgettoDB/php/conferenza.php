<?php
    require_once('connection.php');

    $nomeConf = $_GET["nome"];

    if($dbh->getAmministratore($_SESSION["username"]) != NULL)  
        $templateParams["amministratore"] = $dbh->getAmministratore($_SESSION["username"]);

    //per avere identificativi della conferenza selezionata
    $templateParams["conferenza"] = $dbh->getConferenzaByNome($_GET["nome"]);

    //prende le sessioni a partire dalla conferenza selezionata
    $templateParams["sessione"] = $dbh->getSessionibyConferenza($templateParams["conferenza"][0]["Acronimo"]);

    require 'template/templateConferenza.php';
    
?>