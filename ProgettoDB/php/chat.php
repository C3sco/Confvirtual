<?php
    require_once 'connection.php';

    $codiceSessione = $_GET["codiceSessione"];

    //per avere identificativi della sessione selezionata
    $templateParams["sessione"] = $dbh->getSessioneByCodice($_GET["codiceSessione"]);

    //prende i messaggi dalla sessione selezionata
    $templateParams['messaggi'] = $dbh -> getMessaggiBySessione($templateParams["sessione"][0]["Codice"]);

    //inserisce messaggio nella chat
    if (isset($_POST['btnInserisciMessaggio'])) {
        if(empty($_POST['testo'])){
            $templateParams["msgErroreMess"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $codice = $_GET["codiceSessione"];
            $username = $_SESSION["username"];
            $testo = $_POST["testo"];

            $dbh -> insertMessaggio($codice, $username, $testo);
        } 
    }

    require 'template/templateChat.php';
?>