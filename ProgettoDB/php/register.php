<?php
    require_once('connection.php');    
    
    if (isset($_POST['register'])) {
        if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['nome']) || empty($_POST['cognome']) || empty($_POST['datanascita']) || empty($_POST['luogonascita'])){
            $templateParams["errore"] = "Errore! Non sono stati inseriti alcuni dati";
        } else {
    
            $username = $_POST['username'];
            //$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password = $_POST['password'];
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $datanascita = $_POST["datanascita"];
            $luogonascita = $_POST["luogonascita"];
        
            $dbh->insertUser($username, $password, $nome, $cognome, $datanascita, $luogonascita); 
        
            if($dbh->getUtente($username) != NULL){
                header("location: ./login.php");                           
            }
        }     
    }
    require 'template/templateRegister.php';
?>