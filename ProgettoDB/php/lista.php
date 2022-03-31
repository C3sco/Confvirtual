<?php
    require_once('connection.php');

    //lista delle presentazioni preferite dell'utente
    $templateParams['lista'] = $dbh->getListaByUsername($_SESSION["username"]);

    //lista delle presentazioni a cui è iscritto l'utente
    $templateParams['presentazioni'] = $dbh->getPresentazioni();

    //inserisce presentazione selezionata nella lista delle perferite
    if (isset($_POST['btnInserisciLista'])) {
        if(empty($_POST['presentazione'])){
            $templateParams["msgErroreLista"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
            $username = $_SESSION["username"];
            $codicePres = $_POST['presentazione'];
            try{
            $dbh -> insertLista($username, $codicePres);
            $templateParams["msgLista"] = "Presentazione inserita in lista con successo!";
        }     catch(Exception $err){
            $templateParams['error'] = "Questa presentazione e' già presente nella tua lista!";



        }

    }
    }
    
    require 'template/templateLista.php';
?>