<?php
    require_once 'connection.php';

    if($dbh->getPresenter($_SESSION["username"]) != NULL) {

        //inserimento di TUTTI i dati del presenter
        if (isset($_POST['btnInserisciDati'])) {
            if(empty($_POST['curriculum']) || empty($_POST['foto']) || empty($_POST['nomeUni']) || empty($_POST['nomeDipartimento'])){
                $templateParams["msgErroreDati"] = "Errore! Non sono stati inseriti alcuni dati";
            } else {

            $username = $_SESSION["username"];
            $curriculum = $_POST['curriculum'];
            $foto = $_POST['foto'];
            $nomeUni = $_POST['nomeUni'];
            $nomeDipartimento = $_POST['nomeDipartimento'];
                        
            $dbh->updateDatiPresenter($username, $curriculum, $foto, $nomeUni, $nomeDipartimento);
            $templateParams["msgDati"] = "Dati inseriti con successo!";
            }
        }

        //modifica dati A SCELTA del presenter 
        if (isset($_POST['btnModificaDati'])) {
            
            $username = $_SESSION["username"];
            $curriculum = $_POST['curriculum'];
            $foto = $_POST['foto'];
            $nomeUni = $_POST['nomeUni'];
            $nomeDipartimento = $_POST['nomeDipartimento'];

            if($curriculum!=""){
                $dbh->updateCurriculumPresenter($_SESSION['username'], $curriculum);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }

            if($foto!=""){
                $dbh->updateFotoPresenter($_SESSION['username'], $foto);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }

            if($nomeUni!=""){
                $dbh->updateNomeUniPresenter($_SESSION['username'], $nomeUni);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }

            if($nomeDipartimento!=""){
                $dbh->updateNomeDipartimentoPresenter($_SESSION['username'], $nomeDipartimento);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }           
        }
    }

    elseif($dbh->getSpeaker($_SESSION["username"]) != NULL) {
        
        //inserimento di TUTTI i dati dello speaker
        if (isset($_POST['btnInserisciDati'])) {
            if(empty($_POST['curriculum']) || empty($_POST['foto']) || empty($_POST['nomeUni']) || empty($_POST['nomeDipartimento'])){
                $templateParams["msgErroreDati"] = "Errore! Non sono stati inseriti alcuni dati";
            } else {
                $username = $_SESSION["username"];
                $curriculum = $_POST['curriculum'];
                $foto = $_POST['foto'];
                $nomeUni = $_POST['nomeUni'];
                $nomeDipartimento = $_POST['nomeDipartimento'];
                            
                $dbh->updateDatiSpeaker($username, $curriculum, $foto, $nomeUni, $nomeDipartimento);
                $templateParams["msgDati"] = "Dati inseriti con successo!";
            }
        }

        //modifica dati A SCELTA dello speaker 
        if (isset($_POST['btnModificaDati'])) {
            
            $username = $_SESSION["username"];
            $curriculum = $_POST['curriculum'];
            $foto = $_POST['foto'];
            $nomeUni = $_POST['nomeUni'];
            $nomeDipartimento = $_POST['nomeDipartimento'];

            if($curriculum!=""){
                $dbh->updateCurriculumSpeaker($_SESSION['username'], $curriculum);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }

            if($foto!=""){
                $dbh->updateFotoSpeaker($_SESSION['username'], $foto);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }

            if($nomeUni!=""){
                $dbh->updateNomeUniSpeaker($_SESSION['username'], $nomeUni);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }

            if($nomeDipartimento!=""){
                $dbh->updateNomeDipartimentoSpeaker($_SESSION['username'], $nomeDipartimento);
                $templateParams["msgModDati"] = "Dati modificati con successo!";
            }           
        }
    }

    require 'template/templateModificaDati.php';
?>