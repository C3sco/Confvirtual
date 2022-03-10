<?php
    require_once 'connection.php';

    $templateParams['conferenze'] = $dbh->getConferenze();
    $templateParams['sponsor'] = $dbh->getSponsor();

    //inserisce un nuovo sponsor
    if (isset($_POST['btnInserisciSponsor'])) {    
        if(empty($_POST['nome']) || empty($_POST['logo']) || empty($_POST['importo'])){
            $templateParams["msgErroreSponsor"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $nome = $_POST["nome"];
            $logo = $_POST['logo'];
            $importo = $_POST['importo'];
                        
            $dbh -> insertSponsor($nome, $logo, $importo);
            $templateParams['conferenze'] = $dbh->getConferenze();
            $templateParams["msgCreazioneSponsor"] = "Sponsor inserito con successo!";
        }
    }

    //associazione sponsor-conferenza
    if (isset($_POST['btnAssociaSponsor'])) {
        if(empty($_POST['conferenza']) || empty($_POST['nome'])){
            $templateParams["msgErroreAssSponsor"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $templateParams["conferenza"] = $dbh->getConferenzaByNome($_POST['conferenza']);

            $acronimo =  $templateParams["conferenza"][0]["Acronimo"];
            $anno =  $templateParams["conferenza"][0]["AnnoEdizione"];
            $sponsor = $_POST['nome'];
        
            $dbh -> insertDisposizione($anno, $acronimo, $sponsor);
            $templateParams["msgAssociazioneSponsor"] = "Associazione avvenuta con successo!";
        }     
    }

    require 'template/templateCreaSponsor.php';
?>