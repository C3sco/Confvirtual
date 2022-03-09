<?php
    require_once 'connection.php';

    $templateParams['conferenze'] = $dbh->getConferenze();
    $templateParams['sponsor'] = $dbh->getSponsor();

    if (isset($_POST['btnInserisciSponsor'])) {    
        $nome = $_POST["nome"];
        $logo = $_POST['logo'];
        $importo = $_POST['importo'];
                    
        $dbh -> insertSponsor($nome, $logo, $importo);
        $templateParams['conferenze'] = $dbh->getConferenze();
    }

    if (isset($_POST['btnAssociaSponsor'])) {
        if(empty($_POST['conferenza']) || empty($_POST['nome'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $templateParams["conferenza"] = $dbh->getConferenzaByNome($_POST['conferenza']);

            $acronimo =  $templateParams["conferenza"][0]["Acronimo"];
            $anno =  $templateParams["conferenza"][0]["AnnoEdizione"];
            $sponsor = $_POST['nome'];
        
            $dbh -> insertDisposizione($anno, $acronimo, $sponsor);
        }     
    }

    require 'template/templateCreaSponsor.php';
?>