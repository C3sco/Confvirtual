<?php
    require_once('connection.php');

    if(isset($_POST["username"]) && isset($_POST["password"])){

        $login_result = $dbh->getUtente($_POST["username"]);
        
        if(count($login_result)!=0 && password_verify($_POST["password"], $login_result[0]["Passwordd"])){
            //login successo 
            $_SESSION["username"] = $_POST["username"];
        } else{
            //Login fallito
            $templateParams["errorelogin"] = "Errore! Controllare username o password!";
        }
    }
    
    if(!empty($_SESSION['username'])){
        header("location: paginaUtente.php");  
    } else{
        require 'template/templateLogin.php';
    }
?>