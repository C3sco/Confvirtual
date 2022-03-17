<?php
    require_once 'connection.php';

    $codiceSessione = $_GET["codiceSessione"];

    if(empty($_POST['voto']) || empty($_POST['note'])){
        $templateParams["msgErrVal"] = "Errore! Non sono stati inseriti alcuni dati";
    } else {
        $username = $_SESSION["username"];
        $voto = $_POST["voto"];
        $note = $_POST["note"];
        $presentazione = $_GET["presentazione"];

        $dbh->insertValutazione($presentazione, $username, $voto, $note);
        $templateParams["msgValutazione"] = "Valutazione inserita con successo!";
    }

    header("location: presentazioni.php?codiceSessione=$codiceSessione");
?>