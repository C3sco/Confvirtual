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

     //inserimento valutazione di una presentazione
     if (isset($_POST['btnVoto'])) {
        if(empty($_POST['voto']) || empty($_POST['note'])){
            $templateParams["msgErrVal"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_SESSION["username"];
            $voto = $_POST["voto"];
            $note = $_POST["note"];
            $presentazione = $_GET["presentazione"];
            try{
            $dbh->insertValutazione($presentazione, $username, $voto, $note);
            $templateParams["msgValutazione"] = "Valutazione inserita con successo!";
            }catch(Exception $err){
                $templateParams['error'] = "Valutazione già presente!";
            }
        }
    }

    require 'template/templatePresentazioni.php';
?>