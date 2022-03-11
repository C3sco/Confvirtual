##################    UTENTE    #####################
##Autenticazione alla piattaforma##
DELIMITER $
create procedure AUTENTICAZIONE(IN UsernameUtenteI VARCHAR(100), IN PasswordUtenteI VARCHAR(100))
BEGIN
	DECLARE a VARCHAR(100);
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE PasswordUtenteX VARCHAR(100);
    SET UsernameUtenteX =(SELECT Username FROM UTENTE WHERE(UsernameUtenteX=UsernameUtenteI));
    SET PasswordUtenteX =(SELECT Password FROM UTENTE WHERE(PasswordUtenteX=PasswordUtenteI));
	IF(UsernameUtenteX=1 AND PasswordUtenteX=1) THEN
    SET a = "Benvenuto";
    END IF;
END $
DELIMITER ;

##Registrazione alla piattaforma##
DELIMITER $
drop procedure if EXISTS REGISTRAZIONE $
create procedure REGISTRAZIONE(IN UsernameI VARCHAR(100), IN PasswordI VARCHAR(100), IN NomeI VARCHAR(100),
IN CognomeI VARCHAR(100), IN DataNascitaI DATE, IN LuogoNascitaI VARCHAR(100))
BEGIN 
	DECLARE UsernameX VARCHAR(100);
	SET UsernameX =(SELECT Username FROM UTENTE WHERE(Username=UsernameUtenteI));
		IF(UsernameX<>1) THEN
		INSERT INTO UTENTE(Username,Password,Nome,Cognome,DataNascita,LuogoNascita) VALUES (UsernameI,PasswordI,NomeI,
		CognomeI,DataNascitaI,LuogoNascitaI);
		END IF;
END $ 
DELIMITER ;

##Registrazione ad una conferenza##
DELIMITER $
create procedure REGISTRAZIONE_CONFERENZA(IN AnnoEdizioneConferenzaI INT, IN AcronimoConferenzaI VARCHAR(20),
 IN UsernameUtenteI VARCHAR(100))
BEGIN
	DECLARE AnnoEdizioneConferenzaX INT DEFAULT YEAR(NOW());
    #DECLARE AcronimoConferenzaX VARCHAR(20);
    DECLARE UsernameUtenteX VARCHAR(100);
	SET AnnoEdizioneConferenzaX =(SELECT AnnoEdizione FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI
    AND Svolgimento<>"Completato"));
    #SET AcronimoConferenzaX =(SELECT Acronimo FROM CONFERENZA WHERE(Acronimo=AcronimoConferenzaI)
    SET UsernameUtenteX =(SELECT Username FROM UTENTE WHERE(Username=UsernameUtenteI));
	IF(AnnoEdizioneX=1 AND UsernameUtenteX=1) THEN
    INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente) VALUES (AnnoEdizioneConferenzaI,AcronimoConferenzaI,UsernameUtenteI);
    END IF;
END $
DELIMITER ;

##Inserimento messaggi nella chat di sessione##
DELIMITER $
create procedure INSERIMENTO_MESSAGGIO(IN CodiceSessioneI INT, IN UsernameUtenteI VARCHAR(100), IN TestoMessaggioI VARCHAR(500)) 
BEGIN
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE CodiceSessioneX INT DEFAULT 0;
    SET UsernameUtenteX =(SELECT Username FROM UTENTE WHERE(Username=UsernameUtenteI));
    SET CodiceSessioneX =(SELECT Codice FROM SESSIONE WHERE(Codice=CodiceSessioneI));
    IF(UsernameUtenteX=1 AND CodiceSessioneX=1) THEN
    INSERT INTO MESSAGGIO(CodiceSessione,UsernameUtente,DataMessaggio,TestoMessaggio) VALUES (CodiceSessioneI,UsernameUtenteI,DATE.NOW(),TestoMessaggioI);
    END IF;
END $
DELIMITER ;

##Inserimento lista presentazioni favorite##
DELIMITER $
create procedure INSERIMENTO_FAVORITA(IN UsernameUtenteI VARCHAR(100), IN CodicePresentazioneI INT) 
BEGIN
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE CodicePresentazioneX INT DEFAULT 0;
    SET UsernameUtenteX =(SELECT Username FROM UTENTE WHERE(Username=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT Codice FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
    IF(UsernameUtenteX=1 AND CodiceSessioneX=1) THEN
    INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES (UsernameUtenteI,CodicePresentazioneI);
    END IF;
END $
DELIMITER ;

######################   AMMINISTRATORE    ##########################
##Creazione di una nuova conferenza##		Da rivedere varbinary
DELIMITER $
create procedure CREAZIONE_CONFERENZA(IN AnnoEdizioneI INT, IN AcronimoI VARCHAR(20), IN NomeI VARCHAR(100),
	IN LogoI VARBINARY(MAX), IN SvolgimentoI ENUM("Attiva", "Completata"), IN TotaleSponsorizzazioniI)
BEGIN
	INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) VALUES
    (AnnoEdizioneI,AcronimoI,NomeI,LogoI,SvolgimentoI,TotaleSponsorizzazioniI);
END $
DELIMITER ;

##Creazione di una nuova sessione della conferenza##
DELIMITER $
create procedure CREAZIONE_SESSIONE(IN CodiceI INT, IN TitoloI VARCHAR(100), IN NumeroPresentazioniI INT, IN InizioI
	TIME, IN FineI TIME, IN LinkI VARCHAR(100), IN GiornoGiornataI DATE, IN AnnoEdizioneConferenzaI INT, 
    IN AcronimoConferenzaI VARCHAR(20))
BEGIN
	DECLARE GiornoGiornataX DATE;
    DECLARE AnnoEdizioneConferenzaX INT DEFAULT 2000;
    DECLARE InizioX TIME;
    DECLARE FineX TIME;
    SET InizioX=InizioI;
    SET FineX=FineI;
    SET GiornoGiornataX =(SELECT Giorno FROM GIORNATA WHERE(Giorno=GiornoGiornataI AND AnnoEdizioneConferenza=
    AnnoEdizioneConferenzaI AND AcronimoConferenza=AcronimoConferenzaI));
    SET AnnoEdizioneConferenzaX =(SELECT AnnoEdizione FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND
    AcronimoConferenza=AcronimoConferenzaI));
    IF(GiornoGiornataX=1 AND AnnoEdizioneConferenza=1 AND FineX>InizioX) THEN
    INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
    VALUES (CodiceI,TitoloI,NumeroPresentazioniI,InizioI,FineI,LinkI,GiornoGiornataI,AnnoEdizioneConferenzaI,AcronimoConferenzaI);
    END IF;
END $
DELIMITER ;

##Creazione di una sessione## NO, Nel caso sentiamo il prof

##Inserimento delle presentazioni in una sessione##
DELIMITER $
create procedure INSERIMENTO_PRESENTAZIONI(IN CodiceSessioneI INT, IN CodicePresentazioneI INT)
BEGIN
	DECLARE CodiceSessioneX INT DEFAULT 0;
    DECLARE CodicePresentazioneX INT DEFAULT 1;
	SET CodiceSessioneX =(SELECT Codice FROM SESSIONE WHERE(Codice=CodiceSessioneI));
    SET CodicePresentazioneX =(SELECT Codice FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
	IF(CodiceSessioneX=1 AND CodicePresentazioneX=1) THEN 
	INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (CodiceSessioneI,CodicePresentazioneI);
	END IF;
END $
DELIMITER ;

##Associazione di uno speaker alla presentazione di un tutorial##
DELIMITER $
create procedure ASSOCIAZIONE_SPEAKER(IN UsernameUtenteI VARCHAR(100), IN CodicePresentazioneI INT)
BEGIN
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE CodicePresentazioneX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT Username FROM UTENTE WHERE(Username=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT Codice FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
	IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
	INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES (UsernameUtenteI,CodicePresentazioneI);
	END IF;
END $
DELIMITER ;

##Associazione di un presenter alla presentazione di un articolo##
DELIMITER $
create procedure ASSOCIAZIONE_PRESENTER(IN UsernameUtenteI VARCHAR(100), IN CodicePresentazioneI INT, IN LinkRisorsaI
	VARCHAR(100), IN DescrizioneRisorsaI VARCHAR(100))
BEGIN
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE CodicePresentazioneX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT Username FROM UTENTE WHERE(Username=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT Codice FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
	IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
	INSERT INTO RISORSA(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES 
    (UsernameUtenteI,CodicePresentazioneI,LinkRisorsaI,DescrizioneRisorsaI);
	END IF;
END $
DELIMITER ;

##Inserimento delle valutazioni sulle presentazioni##
DELIMITER $
create procedure INSERIMENTO_VALUTAZIONE(IN CodicePresentazioneI INT, IN UsernameUtenteI VARCHAR(100), IN VotoI INT,
	IN NoteI VARCHAR(100))
BEGIN
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE CodicePresentazioneX INT DEFAULT 0;
	SET UsernameUtenteX =(SELECT UsernameUtente FROM AMMINISTRATORE WHERE(UsernameUtente=UsernameUtenteI));
    SET CodicePresentazioneX =(SELECT Codice FROM PRESENTAZIONE WHERE(Codice=CodicePresentazioneI));
	IF(UsernameUtenteX=1 AND CodicePresentazioneX=1) THEN
    INSERT INTO VALUTAZIONE(CodicePresentazione,UsernameUtente,Voto,Note) VALUES 
    (CodicePresentazioneI,UsernameUtenteI,VotoI,NoteI);
	END IF;
END $
DELIMITER ;

##Inserimento di uno sponsor/sponsorizzazione##
DELIMITER $
create procedure INSERIMENTO_SPONSOR(IN AnnoEdizioneConferenzaI INT, IN AcronimoConferenzaI VARCHAR(20), IN
	NomeSponsorI VARCHAR(100))
BEGIN
	DECLARE AnnoEdizioneConferenzaX INT DEFAULT 2000;
    DECLARE NomeSponsorX VARCHAR(100);
    SET AnnoEdizioneConferenzaX =(SELECT AnnoEdizione FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND
    AcronimoConferenza=AcronimoConferenzaI));
    SET NomeSponsorX =(SELECT Nome FROM SPONSOR WHERE(Nome=NomeSponsorI));
	IF(AnnoEdizioneConferenzaX=1 AND NomeSponsorX=1) THEN
	INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES
    (AnnoEdizioneConferenzaI,AcronimoConferenzaI,NomeSponsorI);
	END IF;
END $
DELIMITER ;
