<?php
    require_once 'connection.php';

    $templateParams['speaker'] = $dbh->getAllSpeaker();
    $templateParams['tutorial'] = $dbh->getTutorial();

    $templateParams['presenter'] = $dbh->getAllPresenter();
    $templateParams['articolo'] = $dbh->getArticolo();

    if (isset($_POST['btnAssociazioneST'])) {
        if(empty($_POST['speaker']) || empty($_POST['tutorial'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_POST['speaker'];
            $codice = $_POST['tutorial'];
        
            $dbh -> insertDimostrazione($username, $codice);
        }     
    }

    if (isset($_POST['btnAssociazionePA'])) {
        if(empty($_POST['presenter']) || empty($_POST['articolo'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_POST['presenter'];
            $codice = $_POST['articolo'];
        
            $dbh -> updatePresenterArticolo($username, $codice);
        }     
    }
    
    require 'template/templateAssociazioni.php';
?>