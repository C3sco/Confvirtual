<?php
    require_once 'connection.php';


        $username = $_SESSION["username"];
        $voto = $_POST["voto"];
        $note = $_POST["note"];
        $presentazione = $_GET["presentazione"];

        $dbh->insertValutazione($presentazione, $username, $voto, $note);

        $nomeConf = $_GET["nome"];

    
        header("location: conferenza.php?nome=$nomeConf");
?>