<?php
    require_once 'connection.php';

    $codiceSessione = $_GET["codiceSessione"];

    //per avere identificativi della sessione selezionata
    $templateParams["sessione"] = $dbh->getSessioneByCodice($_GET["codiceSessione"]);

    //prende i messaggi dalla sessione selezionata
    $templateParams['messaggi'] = $dbh -> getMessaggiBySessione($templateParams["sessione"][0]["Codice"]);

    require 'template/templateChat.php';
?>