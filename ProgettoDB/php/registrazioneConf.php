<?php
    require_once 'connection.php';

    //per iscriversi ad una conferenza
    $templateParams["conferenza"] = $dbh->getConferenzaByNome($_GET["nome"]);

    $annoEdizione = $templateParams["conferenza"][0]["AnnoEdizione"];
    $acronimo = $templateParams["conferenza"][0]["Acronimo"];
    $username = $_SESSION["username"];

    $dbh->insertIscrizione($annoEdizione, $acronimo, $username);

    require 'conferenza.php';
?>