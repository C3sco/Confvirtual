<?php
    require_once 'connection.php';

    //per avere identificativi della conferenza selezionata
    $templateParams["conferenza"] = $dbh->getConferenzaByNome($_GET["nome"]);

    $annoEdizione = $templateParams["conferenza"][0]["AnnoEdizione"];
    $acronimo = $templateParams["conferenza"][0]["Acronimo"];
    $username = $_SESSION["username"];

    //per iscriversi ad una conferenza
    $dbh->insertIscrizione($annoEdizione, $acronimo, $username);

    require 'conferenza.php';
?>