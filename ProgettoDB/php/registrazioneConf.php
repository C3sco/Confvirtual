<?php
    require_once 'connection.php';
    
    
    $nomeConf = $_GET["nome"];

    //per avere identificativi della conferenza selezionata
    $templateParams["conferenza"] = $dbh->getConferenzaByNome($_GET["nome"]);

    $annoEdizione = $templateParams["conferenza"][0]["AnnoEdizione"];
    $acronimo = $templateParams["conferenza"][0]["Acronimo"];
    $username = $_SESSION["username"];

    //iscrizione ad una conferenza
    try{
    $dbh->insertIscrizione($annoEdizione, $acronimo, $username);
    $templateParams["msg"] = "Registrazione alla conferenza avvenuta con successo!";
    require 'paginaUtente.php';
    }
    
    catch(Exception $err){
      $templateParams['error'] = "Sei già iscritto a questa conferenza!";
        require 'paginaUtente.php';
    }
    

    ?>


  