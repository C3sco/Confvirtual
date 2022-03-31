<?php
    require_once 'connection.php';

    $templateParams['presentazioni'] = $dbh -> getPresentazioniValutate();

    require 'template/templateVisualizzaValutazioni.php';
?>