#########	PRESENTER	########
#Inserimento nuovo presenter
DELIMITER $
create procedure REGISTRAZIONE_PRESENTER(IN UsernameUtenteI VARCHAR(100), CurriculumI VARCHAR(30), FotoI VARCHAR(100),
	NomeUniI VARCHAR(100), NomeDipartimentoI VARCHAR(100))
BEGIN 
	UPDATE PRESENTER
    SET Curriculum=CurriculumI,Foto=FotoI,NomeUni=NomeUniI,NomeDipartimento=NomeDipartimentoI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Modifica curriculum presenter
DELIMITER $
create procedure MODIFICA_CURRICULUM(IN UsernameUtenteI VARCHAR(100),IN CurriculumI VARCHAR(30)) 
BEGIN 
	UPDATE PRESENTER
    SET Curriculum=CurriculumI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Modifica nome uni presenter
DELIMITER $
create procedure MODIFICA_NOME_UNI(IN UsernameUtenteI VARCHAR(100),IN NomeUniI VARCHAR(30)) 
BEGIN 
	UPDATE PRESENTER
    SET NomeUni=NomeUniI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Modifica nome dipartimento presenter
DELIMITER $
create procedure MODIFICA_NOME_DIPARTIMENTO(IN UsernameUtenteI VARCHAR(100),IN NomeDipartimentoI VARCHAR(30)) 
BEGIN 
	UPDATE PRESENTER
    SET NomeDipartimento=NomeDipartimentoI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Modifica foto presenter
DELIMITER $
create procedure MODIFICA_FOTO(IN UsernameUtenteI VARCHAR(100),IN FotoI VARCHAR(30)) 
BEGIN 
	UPDATE PRESENTER
    SET Foto=FotoI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

############ SPEAKER ###########
#Inserimento nuovo speaker 
DELIMITER $
create procedure REGISTRAZIONE_SPEAKER(IN UsernameUtenteI VARCHAR(100), CurriculumI VARCHAR(30), FotoI VARCHAR(100),
	NomeUniI VARCHAR(100), NomeDipartimentoI VARCHAR(100))
BEGIN 
	UPDATE SPEAKER
    SET Curriculum=CurriculumI,Foto=FotoI,NomeUni=NomeUniI,NomeDipartimento=NomeDipartimentoI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;
#Modifica curriculum speaker
DELIMITER $
create procedure MODIFICA_CURRICULUM(IN UsernameUtenteI VARCHAR(100),IN CurriculumI VARCHAR(30)) 
BEGIN 
	UPDATE SPEAKER
    SET Curriculum=CurriculumI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Modifica nome uni speaker
DELIMITER $
create procedure MODIFICA_NOME_UNI(IN UsernameUtenteI VARCHAR(100),IN NomeUniI VARCHAR(30)) 
BEGIN 
	UPDATE SPEAKER
    SET NomeUni=NomeUniI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Modifica nome dipartimento speaker
DELIMITER $
create procedure MODIFICA_NOME_DIPARTIMENTO(IN UsernameUtenteI VARCHAR(100),IN NomeDipartimentoI VARCHAR(30)) 
BEGIN 
	UPDATE SPEAKER
    SET NomeDipartimento=NomeDipartimentoI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Modifica foto speaker
DELIMITER $
create procedure MODIFICA_FOTO(IN UsernameUtenteI VARCHAR(100),IN FotoI VARCHAR(30)) 
BEGIN 
	UPDATE SPEAKER
    SET Foto=FotoI
    WHERE UsernameUtente=UsernameUtenteI;
END $
DELIMITER ;

#Inserimento nuova risorsa
DELIMITER $
create procedure CREAZIONE_RISORSA(UsernameUtenteI VARCHAR(100),CodicePresentazioneI INT, LinkRisorsaI VARCHAR(100), DescrizioneRisorsaI VARCHAR(100))
BEGIN
	DECLARE UsernameUtenteX INT DEFAULT 0;
    DECLARE CodicePresentazioneX INT DEFAULT 0;
    SET UsernameUtenteX =(SELECT COUNT(*) FROM SPEAKER WHERE(UsernameUtente=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT COUNT(*) FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
	IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
		INSERT INTO RISORSA(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES (UsernameUtenteI,CodicePresentazioneI,
        LinkRisorsaI,DescrizioneRisorsaI);
	END IF;
END $
DELIMITER ;

#Modifica dati risorsa
DELIMITER $
create procedure MODIFICA_LINK_RISORSA(IN UsernameUtenteI VARCHAR(100),IN CodicePresentazioneI INT, LinkRisorsaI VARCHAR(100)) 
BEGIN 
	UPDATE RISORSA
    SET LinkRisorsa=LinkRisorsaI
    WHERE UsernameUtente=UsernameUtenteI AND CodicePresentazione=CodicePresentazioneI;
END $
DELIMITER ;

#Modifica descrizione risorsa
DELIMITER $
create procedure MODIFICA_DESCRIZIONE_RISORSA(IN UsernameUtenteI VARCHAR(100),IN CodicePresentazioneI INT, DescrizioneRisorsaI VARCHAR(100)) 
BEGIN 
	UPDATE RISORSA
    SET DescrizioneRisorsa=DescrizioneRisorsaI
    WHERE UsernameUtente=UsernameUtenteI AND CodicePresentazione=CodicePresentazioneI;
END $
DELIMITER ;