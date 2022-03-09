<?php
    require_once 'connection.php';

    if($dbh->getPresenter($_SESSION["username"]) != NULL) {

        if (isset($_POST['btnInserisciDati'])) {
            
            $username = $_SESSION["username"];
            $curriculum = $_POST['curriculum'];
            $foto = $_POST['foto'];
            $nomeUni = $_POST['nomeUni'];
            $nomeDipartimento = $_POST['nomeDipartimento'];
                        
            $dbh->updateDatiPresenter($username, $curriculum, $foto, $nomeUni, $nomeDipartimento);
                
        }

        if (isset($_POST['btnModificaDati'])) {
            
            $username = $_SESSION["username"];
            $curriculum = $_POST['curriculum'];
            $foto = $_POST['foto'];
            $nomeUni = $_POST['nomeUni'];
            $nomeDipartimento = $_POST['nomeDipartimento'];

            if($curriculum!=""){
                $dbh->updateCurriculumPresenter($_SESSION['username'], $curriculum);
            }

            if($foto!=""){
                $dbh->updateFotoPresenter($_SESSION['username'], $foto);
            }

            if($nomeUni!=""){
                $dbh->updateNomeUniPresenter($_SESSION['username'], $nomeUni);
            }

            if($nomeDipartimento!=""){
                $dbh->updateNomeDipartimentoPresenter($_SESSION['username'], $nomeDipartimento);
            }           
        }
    }

    elseif($dbh->getSpeaker($_SESSION["username"]) != NULL) {
        
        if (isset($_POST['btnInserisciDati'])) {
            
            $username = $_SESSION["username"];
            $curriculum = $_POST['curriculum'];
            $foto = $_POST['foto'];
            $nomeUni = $_POST['nomeUni'];
            $nomeDipartimento = $_POST['nomeDipartimento'];
                        
            $dbh->updateDatiSpeaker($username, $curriculum, $foto, $nomeUni, $nomeDipartimento);
                
        }

        if (isset($_POST['btnModificaDati'])) {
            
            $username = $_SESSION["username"];
            $curriculum = $_POST['curriculum'];
            $foto = $_POST['foto'];
            $nomeUni = $_POST['nomeUni'];
            $nomeDipartimento = $_POST['nomeDipartimento'];

            if($curriculum!=""){
                $dbh->updateCurriculumSpeaker($_SESSION['username'], $curriculum);
            }

            if($foto!=""){
                $dbh->updateFotoSpeaker($_SESSION['username'], $foto);
            }

            if($nomeUni!=""){
                $dbh->updateNomeUniSpeaker($_SESSION['username'], $nomeUni);
            }

            if($nomeDipartimento!=""){
                $dbh->updateNomeDipartimentoSpeaker($_SESSION['username'], $nomeDipartimento);
            }           
        }
    }

    require 'template/templateModificaDati.php';
?>