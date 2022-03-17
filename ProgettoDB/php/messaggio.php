<?php
    require_once 'connection.php';

    $codiceSessione = $_GET["codiceSessione"];

    //inserisce messaggio nella chat
    if(empty($_POST['testo'])){
        $templateParams["msgErroreMess"] = "Errore! Non sono stati inseriti alcuni dati";
    } else {
        $codice = $_GET["codiceSessione"];
        $username = $_SESSION["username"];
        $testo = $_POST["testo"];
    
        $dbh -> insertMessaggio($codice, $username, $testo);
        $templateParams["msgMess"] = "Messaggio inviato con successo!";
    }     

    header("location: chat.php?codiceSessione=$codiceSessione");
?>