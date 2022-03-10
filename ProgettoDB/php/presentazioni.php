<?php
    require_once('connection.php');

    $codiceSessione = $_GET["codiceSessione"];

    //per rendere visibile la valutazione solo agli utenti amministratore
    if($dbh->getAmministratore($_SESSION["username"]) != NULL)  {
        $templateParams["amministratore"] = $dbh->getAmministratore($_SESSION["username"]);
    }

    //per avere identificativi della sessione selezionata
    $templateParams["sessione"] = $dbh->getSessioneByCodice($_GET["codiceSessione"]);

    //prende le presentazioni a partire dalla sessione selezionata
    $templateParams["presentazioni"] = $dbh->getPresentazioniBySessione($templateParams["sessione"][0]["Codice"]);
    
    require 'template/templatePresentazioni.php';
?>