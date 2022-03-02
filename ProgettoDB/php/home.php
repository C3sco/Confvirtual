<?php
    require_once 'connection.php';

    $templateParams["conferenze"] = $dbh->getNumConferenze();
    $templateParams["conferenzeAttive"] = $dbh->getNumConferenzeAttive();
    $templateParams["utenti"] = $dbh->getNumUtenti();

    require 'template/templateHome.php';
?>