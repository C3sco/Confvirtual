<?php
    require_once 'connection.php';

    $nomeConf = $_GET["nome"];

    //per avere identificativi della conferenza selezionata
    $templateParams["conferenza"] = $dbh->getConferenzaByNome($_GET["nome"]);

    $annoEdizione = $templateParams["conferenza"][0]["AnnoEdizione"];
    $acronimo = $templateParams["conferenza"][0]["Acronimo"];
    $username = $_SESSION["username"];

    //iscrizione ad una conferenza
    $dbh->insertIscrizione($annoEdizione, $acronimo, $username);
    $templateParams["msg"] = "Registrazione alla conferenza avventura con successo!";

    require 'paginaUtente.php';
?>