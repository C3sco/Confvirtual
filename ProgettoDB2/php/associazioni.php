<?php
    require_once 'connection.php';

    $templateParams['speaker'] = $dbh->getAllSpeaker();
    $templateParams['tutorial'] = $dbh->getTutorial();

    $templateParams['presenter'] = $dbh->getAllPresenter();
    $templateParams['articolo'] = $dbh->getArticolo();

    //asscociazione speaker-tutorial
    if (isset($_POST['btnAssociazioneST'])) {
        if(empty($_POST['speaker']) || empty($_POST['tutorial'])){
            $templateParams["msgErroreSP"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_POST['speaker'];
            $codice = $_POST['tutorial'];
        
            $dbh -> insertDimostrazione($username, $codice);
            $templateParams["msgAssociazioneSP"] = "Associazione avvenuta con successo!";
        }     
    }

    //associazione presenter-articolo
    if (isset($_POST['btnAssociazionePA'])) {
        if(empty($_POST['presenter']) || empty($_POST['articolo'])){
            $templateParams["msgErrorePA"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_POST['presenter'];
            $codice = $_POST['articolo'];
        
            $dbh -> updatePresenterArticolo($username, $codice);
            $templateParams["msgAssociazionePA"] = "Associazione avvenuta con successo!";
        }     
    }
    
    require 'template/templateAssociazioni.php';
?>