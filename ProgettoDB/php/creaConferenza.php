<?php
    require_once 'connection.php';

    $templateParams['conferenze'] = $dbh->getConferenze();
    $templateParams["giornate"] = null;
    $templateParams["conferenza"] = null;

    //creare una nuova conferenza
    if (isset($_POST['btnCreaConferenza'])) {
        if(empty($_POST['anno']) || empty($_POST['acronimo']) || empty($_POST['nome']) || empty($_POST['logo'])){
            $templateParams["erroreConferenza"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_SESSION["username"];

            $anno = $_POST['anno'];
            $acronimo = $_POST['acronimo'];
            $nome = $_POST['nome'];
            $logo = $_POST['logo'];
        
            $dbh -> insertConferenza($anno, $acronimo, $nome, $logo);
            $dbh -> insertCreazioneConf($anno, $acronimo, $username);
            $dbh -> insertIscrizione($anno, $acronimo, $username);

            $templateParams['conferenze'] = $dbh->getConferenze();
            $templateParams["msgConferenza"] = "Conferenza creata con successo!";
        }     
    }
    //aggiungere le giornate ad una conferenza
    if (isset($_POST['btnAggiungiData'])) {
        if(empty($_POST['data']) || empty($_POST['conferenza'])){
            $templateParams["erroreDataConferenza"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $templateParams["conferenza"] = $dbh->getConferenzaByNome($_POST['conferenza']);

            $data = $_POST['data'];
            $acronimo =  $templateParams["conferenza"][0]["Acronimo"];
            $anno =  $templateParams["conferenza"][0]["AnnoEdizione"];
                    
            $dbh->insertDataConferenza($acronimo, $anno, $data);
            $templateParams["msgDataConferenza"] = "Conferenza creata con successo!";

        }     
    }

    //selezionare a quale conferenza aggiungere la nuova sessione e in che giornata
    if (isset($_POST['btnSelezionaConferenza'])) {
        $templateParams["conferenza"] = $dbh->getConferenzaByNome($_POST['conferenza']);
        $templateParams["giornate"] = $dbh->getGiornate($templateParams["conferenza"][0]["Acronimo"]);
    }
    //aggiungere la sessione
    if (isset($_POST['btnCreaSessione'])) {
        if(empty($_POST['giornate']) || empty($_POST['codice']) || empty($_POST['titolo']) || empty($_POST['inizio']) || empty($_POST['fine']) || empty($_POST['link'])){
            $templateParams["erroreSessione"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $templateParams["conferenza2"] = $dbh->getConferenzaByNome($_POST['conferenza2']);

            $acronimo =  $templateParams["conferenza2"][0]["Acronimo"];
            $anno =  $templateParams["conferenza2"][0]["AnnoEdizione"];
            $giornata = $_POST['giornate'];
            $codice = $_POST['codice'];
            $titolo = $_POST['titolo'];
            $inizio = $_POST['inizio'];
            $fine = $_POST['fine'];
            $link = $_POST['link'];
        
            $dbh -> insertSessione($codice, $titolo, $inizio, $fine, $link, $giornata, $anno, $acronimo);
            $templateParams["msgSessione"] = "Conferenza creata con successo!";

        }        
    }
    require 'template/templateCreaConferenza.php';
?>