<?php
    require_once 'connection.php';

    $templateParams['sessioni'] = $dbh->getSessioni();
    $templateParams['presentazioni'] = $dbh->getPresentazioni();

    //associazione sessione-presentazione
    
    if (isset($_POST['btnInserisciPresentazione'])) {
        if(empty($_POST['sessione']) || empty($_POST['presentazione'])){
            $templateParams["msgErrore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $codiceSess = $_POST['sessione'];
            $codicePres = $_POST['presentazione'];
            try{
            $dbh -> insertFormazione($codiceSess, $codicePres);
           #$templateParams["msgPresentazione"] = "Presentazione inserita con successo!";
        }  
        catch(Exception $err){
            $templateParams['error'] = "Questa presentazione fa già parte della sessione!";
        }
    }   
    }
    
    require 'template/templateInsertPresentazione.php';
?>