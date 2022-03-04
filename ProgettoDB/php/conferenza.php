<?php
    require_once('connection.php');

    //per avere identificativi della conferenza selezionata
    $templateParams["conferenza"] = $dbh->getConferenzaByNome($_GET["nome"]);

    //prende le sessioni a partire dalla conferenza selezionata
    $templateParams["sessione"] = $dbh->getSessionibyConferenza($templateParams["conferenza"][0]["Acronimo"]);

    require 'template/templateConferenza.php';
    
?>