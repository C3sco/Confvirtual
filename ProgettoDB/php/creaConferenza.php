<?php
    require_once 'connection.php';

    $templateParams['conferenze'] = $dbh->getConferenze();
    $templateParams["giornate"] = null;

    if (isset($_POST['btnCreaConferenza'])) {
        if(empty($_POST['anno']) || empty($_POST['acronimo']) || empty($_POST['nome']) || empty($_POST['logo'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
    
            $anno = $_POST['anno'];
            $acronimo = $_POST['acronimo'];
            $nome = $_POST['nome'];
            $logo = $_POST['logo'];
        
            $dbh->insertConferenza($anno, $acronimo, $nome, $logo);
            $templateParams['conferenze'] = $dbh->getConferenze();
        }     
    }

    if (isset($_POST['btnAggiungiData'])) {
        if(empty($_POST['data']) || empty($_POST['conferenza'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $templateParams["conferenza"] = $dbh->getConferenzaByNome($_POST['conferenza']);
            $data = $_POST['data'];
            $acronimo =  $templateParams["conferenza"][0]["Acronimo"];
            $anno =  $templateParams["conferenza"][0]["AnnoEdizione"];
                    
            $dbh->insertDataConferenza($acronimo, $anno, $data);
        }     
    }


    if (isset($_POST['btnSelezionaConferenza'])) {
        $templateParams["conferenza"] = $dbh->getConferenzaByNome($_POST['conferenza']);
        $templateParams["giornate"] = $dbh->getGiornate($templateParams["conferenza"][0]["Acronimo"]);
    }


    if (isset($_POST['btnAggiungiSessione'])) {
        if(empty($_POST['giornata']) || empty($_POST['conferenza'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $data = $_POST['data'];
            $acronimo =  $templateParams["conferenza"][0]["Acronimo"];
            $anno =  $templateParams["conferenza"][0]["AnnoEdizione"];
                    
            $dbh->insertDataConferenza($acronimo, $anno, $data);
        }     
    }
    require 'template/templateCreaConferenza.php';
?>