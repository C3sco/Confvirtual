<?php
    require_once 'connection.php';

    $templateParams['tutorial'] = $dbh->getTutorialBySpeaker($_SESSION["username"]);

    //inserimento di TUTTI i dati della risorsa
    if (isset($_POST['btnInserisciRisorsa'])) {
        if(empty($_POST['tutorial']) || empty($_POST['link']) || empty($_POST['descrizione'])){
            $templateParams["msgErrAggiuntaRisorsa"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_SESSION["username"];
            $tutorial = $_POST['tutorial'];
            $link = $_POST['link'];
            $descrizione = $_POST['descrizione'];
                        
            $dbh->insertRisorsa($username, $tutorial, $link, $descrizione);    
            $templateParams["msgAggiuntaRisorsa"] = "Dati risorsa inserti con successo!";
        }  
    }

    //modifica dati A SCELTA della risorsa 
    if (isset($_POST['btnModificaRisorsa'])) {
        
        $username = $_SESSION["username"];
        $tutorial = $_POST['tutorial'];
        $link = $_POST['link'];
        $descrizione = $_POST['descrizione'];

        if($link!=""){
            $dbh->updateLinkRisorsa($username, $tutorial, $link);
            $templateParams["msgModificaRisorsa"] = "Dati risorsa aggiurnati con successo!";
        }

        if($descrizione!=""){
            $dbh->updateDescrizioneRisorsa($username, $tutorial, $descrizione);
            $templateParams["msgModificaRisorsa"] = "Dati risorsa aggiurnati con successo!";
        }       
    }

    require 'template/templateCreaRisorsa.php';
?>