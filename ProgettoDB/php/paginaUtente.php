<?php
    require_once('connection.php');

    //per visualizzare tutte le conferenza disponibili
    $templateParams["conferenze"] = $dbh->getConferenze();

    require 'template/templatePaginaUtente.php';
    
?>