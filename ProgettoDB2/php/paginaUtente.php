<?php
    require_once('connection.php');

    $templateParams["conferenze"] = $dbh->getConferenze();
    
    //per visualizzare la grafica associata ad ogni tipologia di utente 
    if($dbh->getSpeaker($_SESSION["username"]) != NULL)
        $templateParams["speaker"] = $dbh->getSpeaker($_SESSION["username"]);
    if($dbh->getPresenter($_SESSION["username"]) != NULL)  
        $templateParams["presenter"] = $dbh->getPresenter($_SESSION["username"]);
    if($dbh->getAmministratore($_SESSION["username"]) != NULL)  
        $templateParams["amministratore"] = $dbh->getAmministratore($_SESSION["username"]);

    require 'template/templatePaginaUtente.php';
    
?>