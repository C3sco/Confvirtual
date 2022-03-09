<?php
    require_once 'connection.php';

    $templateParams['sessioni'] = $dbh->getSessioni();
    $templateParams['presentazioni'] = $dbh->getPresentazioni();

    if (isset($_POST['btnInserisciPresentazione'])) {
        if(empty($_POST['sessione']) || empty($_POST['presentazione'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $codiceSess = $_POST['sessione'];
            $codicePres = $_POST['presentazione'];
        
            $dbh -> insertFormazione($codiceSess, $codicePres);
        }     
    }
    
    require 'template/templateInsertPresentazione.php';
?>