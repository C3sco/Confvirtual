/*OPERAZIONI UTENTI GENERICI*/

#Registrazione nuovo utente
DELIMITER $
CREATE PROCEDURE REGISTRAZIONE(IN UsernameI VARCHAR(100), IN PasswordI VARCHAR(100), IN NomeI VARCHAR(100),
	IN CognomeI VARCHAR(100), IN DataNascitaI DATE, IN LuogoNascitaI VARCHAR(100))
BEGIN 
	DECLARE UsernameX INT DEFAULT 0;
	SET UsernameX =(SELECT COUNT(*) FROM UTENTE WHERE(Username=UsernameI));
	IF(UsernameX<>1) THEN
		INSERT INTO UTENTE(Username,Passwordd,Nome,Cognome,DataNascita,LuogoNascita) 
        VALUES (UsernameI,PasswordI,NomeI,CognomeI,DataNascitaI,LuogoNascitaI);
	END IF;
END $ 
DELIMITER ;

#Iscrizione ad una conferenza
DELIMITER $
CREATE PROCEDURE REGISTRAZIONE_CONFERENZA(IN AnnoEdizioneConferenzaI INT, IN AcronimoConferenzaI VARCHAR(20), IN UsernameUtenteI VARCHAR(100))
BEGIN
	DECLARE AnnoEdizioneConferenzaX INT DEFAULT 0;
    DECLARE AcronimoConferenzaX INT DEFAULT 0;
    DECLARE UsernameUtenteX INT DEFAULT 0;
	SET AnnoEdizioneConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI
		AND Svolgimento <> "Completato"));
	SET AcronimoConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI
		AND Svolgimento <> "Completato"));
    SET UsernameUtenteX =(SELECT COUNT(*) FROM UTENTE WHERE(Username=UsernameUtenteI));
	IF(AnnoEdizioneConferenzaX=1 AND AcronimoConferenzaX=1 AND UsernameUtenteX=1) THEN
		INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente) VALUES (AnnoEdizioneConferenzaI,AcronimoConferenzaI,UsernameUtenteI);
    END IF;
END $
DELIMITER ;

#Inserimento messaggi nella chat di sessione
DELIMITER $
create procedure INSERIMENTO_MESSAGGIO(IN CodiceSessioneI INT, IN UsernameUtenteI VARCHAR(100), IN TestoMessaggioI VARCHAR(500)) 
BEGIN
	DECLARE UsernameUtenteX INT DEFAULT 0;
    DECLARE CodiceSessioneX INT DEFAULT 0;
    SET UsernameUtenteX =(SELECT COUNT(*) FROM UTENTE WHERE(Username=UsernameUtenteI));
    SET CodiceSessioneX =(SELECT COUNT(*) FROM SESSIONE WHERE(Codice=CodiceSessioneI));
    IF(UsernameUtenteX=1 AND CodiceSessioneX=1) THEN
		INSERT INTO MESSAGGIO(CodiceSessione,UsernameUtente,DataMessaggio,TestoMessaggio) 
        VALUES (CodiceSessioneI,UsernameUtenteI,DATE.NOW(),TestoMessaggioI);
    END IF;
END $
DELIMITER ;

#Inserimento lista presentazioni favorite
DELIMITER $
CREATE PROCEDURE INSERIMENTO_FAVORITA(IN UsernameUtenteI VARCHAR(100), IN CodicePresentazioneI INT) 
BEGIN
	DECLARE UsernameUtenteX INT DEFAULT 0;
    DECLARE CodicePresentazioneX INT DEFAULT 0;
    SET UsernameUtenteX =(SELECT COUNT(*) FROM UTENTE WHERE(Username=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT COUNT(*) FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
    IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
		INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES (UsernameUtenteI,CodicePresentazioneI);
    END IF;
END $
DELIMITER ;


/*OPERAZIONI AMMINISTRATORE*/

#Creazione di una nuova conferenza
DELIMITER $
CREATE PROCEDURE CREAZIONE_CONFERENZA(IN AnnoEdizioneI INT, IN AcronimoI VARCHAR(20), IN NomeI VARCHAR(100),
	IN LogoI VARCHAR(100)) 
BEGIN
	DECLARE AnnoEdizioneX INT DEFAULT 0;
    DECLARE AcronimoX INT DEFAULT 0;
	SET AnnoEdizioneX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneI AND Acronimo=AcronimoI));
	SET AcronimoX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneI AND Acronimo=AcronimoI));
	IF(AnnoEdizioneX<>1 AND AcronimoX<>1) THEN
		INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo) 
        VALUES (AnnoEdizioneI,AcronimoI,NomeI,LogoI);
	END IF;
END $
DELIMITER ;

#Creazione di una nuova sessione della conferenza
DELIMITER $
CREATE PROCEDURE CREAZIONE_SESSIONE(IN CodiceI INT, IN TitoloI VARCHAR(100), IN InizioI TIME, 
	IN FineI TIME, IN LinkI VARCHAR(100), IN GiornoGiornataI DATE, IN AnnoEdizioneConferenzaI INT, 
    IN AcronimoConferenzaI VARCHAR(20))
BEGIN
	DECLARE GiornoGiornataX INT DEFAULT 0;
    DECLARE AnnoEdizioneX INT DEFAULT 0;
    DECLARE AcronimoX INT DEFAULT 0;
    SET GiornoGiornataX =(SELECT COUNT(*) FROM GIORNATA WHERE(Giorno=GiornoGiornataI AND AnnoEdizioneConferenza=AnnoEdizioneConferenzaI AND AcronimoConferenza=AcronimoConferenzaI));
    SET AnnoEdizioneX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
	SET AcronimoX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
    IF(GiornoGiornataX=1 AND AnnoEdizioneX=1 AND AcronimoX=1) THEN
		INSERT INTO SESSIONE(Codice,Titolo,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
		VALUES (CodiceI,TitoloI,InizioI,FineI,LinkI,GiornoGiornataI,AnnoEdizioneConferenzaI,AcronimoConferenzaI);
    END IF;
END $
DELIMITER ;

#Inserimento delle presentazioni in una sessione
DELIMITER $
CREATE PROCEDURE INSERIMENTO_PRESENTAZIONI(IN CodiceSessioneI INT, IN CodicePresentazioneI INT)
BEGIN
	DECLARE CodiceSessioneX INT DEFAULT 0;
    DECLARE CodicePresentazioneX INT DEFAULT 0;
	SET CodiceSessioneX =(SELECT COUNT(*) FROM SESSIONE WHERE(Codice=CodiceSessioneI));
    SET CodicePresentazioneX =(SELECT COUNT(*) FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
	IF(CodiceSessioneX=1 AND CodicePresentazioneX=1) THEN 
		INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (CodiceSessioneI,CodicePresentazioneI);
	END IF;
END $
DELIMITER ;

#Associazione di uno speaker alla presentazione di un tutorial
DELIMITER $
CREATE PROCEDURE ASSOCIAZIONE_SPEAKER(IN UsernameUtenteI VARCHAR(100), IN CodicePresentazioneI INT)
BEGIN
	DECLARE UsernameUtenteX INT DEFAULT 0;
    DECLARE CodicePresentazioneX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT COUNT(*) FROM SPEAKER WHERE(UsernameUtente=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT COUNT(*) FROM TUTORIAL WHERE(CodicePresentazione=CodicePresentazioneI));
	IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
		INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES (UsernameUtenteI,CodicePresentazioneI);
	END IF;
END $
DELIMITER ;

#Associazione di un presenter alla presentazione di un articolo
DELIMITER $
CREATE PROCEDURE ASSOCIAZIONE_PRESENTER(IN UsernameUtenteI VARCHAR(100), IN CodicePresentazioneI INT)
BEGIN
	DECLARE UsernameUtenteX INT DEFAULT 0;
    DECLARE CodicePresentazioneX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT COUNT(*) FROM PRESENTER WHERE(UsernameUtente=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT COUNT(*) FROM ARTICOLO WHERE(CodicePresentazione=CodicePresentazioneI) AND StatoSvolgimento="Non Coperto");
	IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
		UPDATE ARTICOLO SET UsernameUtente=UsernameUtenteI WHERE CodicePresentazione=CodicePresentazioneI;
	END IF;
END $
DELIMITER ;

#Inserimento delle valutazioni sulle presentazioni
DELIMITER $
CREATE PROCEDURE INSERIMENTO_VALUTAZIONE(IN CodicePresentazioneI INT, IN UsernameUtenteI VARCHAR(100), IN VotoI INT,
	IN NoteI VARCHAR(100))
BEGIN
	DECLARE UsernameUtenteX INT DEFAULT 0;
    DECLARE CodicePresentazioneX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT COUNT(*) FROM AMMINISTRATORE WHERE (UsernameUtente=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT COUNT(*) FROM PRESENTAZIONE WHERE (Codice=CodicePresentazioneI));
	IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
		INSERT INTO VALUTAZIONE(CodicePresentazione,UsernameUtente,Voto,Note) 
        VALUES (CodicePresentazioneI,UsernameUtenteI,VotoI,NoteI);
	END IF;
END $
DELIMITER ;

#Inserimento di uno sponsor
DELIMITER $
CREATE PROCEDURE INSERIMENTO_SPONSORINZZAZIONE(IN AnnoEdizioneConferenzaI INT, IN AcronimoConferenzaI VARCHAR(20), 
	IN NomeSponsorI VARCHAR(100))
BEGIN
	DECLARE AnnoEdizioneConferenzaX INT DEFAULT 0;
    DECLARE AcronimoConferenzaX INT DEFAULT 0;
    DECLARE NomeSponsorX INT DEFAULT 0;
    SET AnnoEdizioneConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
	SET AcronimoConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
    SET NomeSponsorX =(SELECT COUNT(*) FROM SPONSOR WHERE(Nome=NomeSponsorI));
	IF(AnnoEdizioneConferenzaX=1 AND AcronimoConferenzaX=1 AND NomeSponsorX=1) THEN
		INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES
		(AnnoEdizioneConferenzaI,AcronimoConferenzaI,NomeSponsorI);
	END IF;
END $
DELIMITER ;

#Inserimento nuovo amministratore
DELIMITER $
create procedure REGISTRAZIONE_AMMINISTRATORE(IN UsernameUtenteI VARCHAR(100))
BEGIN 
	DECLARE UsernameUtenteX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT COUNT(*) FROM UTENTE WHERE(Username=UsernameUtenteI));
		IF(UsernameUtenteX=1) THEN
		INSERT INTO AMMINISTRATORE(UsernameUtente) VALUES (UsernameUtenteI);
		END IF;
END $ 
DELIMITER ;

#Inserimento nuovo speaker (solo username)
DELIMITER $
create procedure REGISTRAZIONE_SPEAKER(IN UsernameUtenteI VARCHAR(100))
BEGIN 
	DECLARE UsernameUtenteX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT COUNT(*) FROM UTENTE WHERE(Username=UsernameUtenteI));
		IF(UsernameUtenteX=1) THEN
		INSERT INTO SPEAKER(UsernameUtente,Curriculum,Foto,NomeUni,NomeDipartimento) VALUES (UsernameUtenteI,NULL,NULL,NULL,NULL);
		END IF;
END $ 
DELIMITER ;

#Inserimento nuovo presenter (solo username)
DELIMITER $
create procedure REGISTRAZIONE_PRESENTER(IN UsernameUtenteI VARCHAR(100))
BEGIN 
	DECLARE UsernameUtenteX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT COUNT(*) FROM UTENTE WHERE(Username=UsernameUtenteI));
		IF(UsernameUtenteX=1) THEN
		INSERT INTO PRESENTER(UsernameUtente,Curriculum,Foto,NomeUni,NomeDipartimento) VALUES (UsernameUtenteI,NULL,NULL,NULL,NULL);
		END IF;
END $ 
DELIMITER ;

#Inserimento giorni di una conferenza
DELIMITER $
create procedure INSERIMENTO_GIORNO(IN AnnoEdizioneConferenzaI INT, AcronimoConferenzaI VARCHAR(20), GiornoI DATE)
BEGIN 
	DECLARE AnnoEdizioneConferenzaX INT DEFAULT 0;
	SET AnnoEdizioneConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
	IF(AnnoEdizioneConferenzaX=1) THEN
	INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza,Giorno) VALUES (AnnoEdizioneConferenzaI,AcronimoConferenzaI,GiornoI);
	END IF;
END $
DELIMITER ;

#Inserimento creazione conferenza con utente admin che viene iscritto direttamente all conferenza
DELIMITER $
create procedure INSERIMENTO_CREAZIONE(IN AnnoEdizioneConferenzaI INT, AcronimoConferenzaI VARCHAR(20), UsernameUtenteI VARCHAR(100))
BEGIN 
	DECLARE AnnoEdizioneConferenzaX INT DEFAULT 0;
    DECLARE UsernameUtenteX INT DEFAULT 0;
	SET AnnoEdizioneConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
	SET UsernameUtenteX =(SELECT COUNT(*) FROM AMMINISTRATORE WHERE(UsernameUtente=UsernameUtenteX));
    IF(AnnoEdizioneConferenzaX=1 AND UsernameUtenteX=1) THEN
	INSERT INTO CREAZIONE(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente) VALUES (AnnoEdizioneConferenzaI,AcronimoConferenzaI,UsernameUtenteI);
	INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente) VALUES (AnnoEdizioneConferenzaI,AcronimoConferenzaI,UsernameUtenteI);
    END IF;
END $
DELIMITER ;

#Creazione nuovo sponsor
DELIMITER $
CREATE PROCEDURE CREAZIONE_SPONSOR(IN NomeI VARCHAR(100), LogoI VARCHAR(100), ImportoI DOUBLE)
BEGIN
	DECLARE NomeX INT DEFAULT 0;
    SET NomeX =(SELECT COUNT(*) FROM SPONSOR WHERE(Nome=NomeI));
	IF(NomeX<>1) THEN
		INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES (NomeI,LogoI,ImportoI);
	END IF;
END $
DELIMITER ;

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