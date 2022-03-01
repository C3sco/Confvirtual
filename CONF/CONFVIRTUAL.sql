drop database if exists CONFVIRTUAL;
create database CONFVIRTUAL;
use CONFVIRTUAL;

create table CONFERENZA(
	AnnoEdizione INT DEFAULT 2000 UNIQUE,
    Acronimo VARCHAR(20) UNIQUE,
    Nome VARCHAR(100),
    Logo LONGBLOB,
    Giorno DATE UNIQUE, 
    Svolgimento ENUM("Attiva","Completata"),
    TotaleSponsorizzazioni INT,
    PRIMARY KEY(AnnoEdizione,Acronimo)
    ) ENGINE=INNODB;

create table SPONSOR(
	Nome VARCHAR(100) PRIMARY KEY UNIQUE,
	Logo LONGBLOB,
	Importo DOUBLE
	) ENGINE=INNODB;
    
create table DISPOSIZIONE(
	AnnoEdizioneConferenza INT DEFAULT 2000,
    AcronimoConferenza VARCHAR(20),
    NomeSponsor VARCHAR(100),
    PRIMARY KEY (AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor),
    FOREIGN KEY(AnnoEdizioneConferenza) REFERENCES CONFERENZA(AnnoEdizione) ON DELETE CASCADE,
    FOREIGN KEY(AcronimoConferenza) REFERENCES CONFERENZA(Acronimo) ON DELETE CASCADE,
    FOREIGN KEY(NomeSponsor) REFERENCES SPONSOR(Nome) ON DELETE CASCADE
	
    ) ENGINE=INNODB;

create table GIORNATA(
    Giorno DATE UNIQUE,
    AnnoEdizioneConferenza INT,
    AcronimoConferenza  VARCHAR(20),
    PRIMARY KEY(Giorno,AnnoEdizioneConferenza,AcronimoConferenza),
	FOREIGN KEY(AnnoEdizioneConferenza) REFERENCES CONFERENZA(AnnoEdizione),
	FOREIGN KEY(AcronimoConferenza) REFERENCES CONFERENZA(Acronimo),
    FOREIGN KEY(Giorno) REFERENCES CONFERENZA(Giorno)
    )ENGINE=INNODB;

create table SESSIONE(
    Codice INT PRIMARY KEY,
    Titolo VARCHAR(100),     #massimo 100 caratteri
    NumeroPresentazioni INT,  #da collegare
    Inizio TIME, #check(Inizio>Fine),
    Fine TIME, #check(Fine<Inizio),
    Link VARCHAR(100),
    GiornoGiornata DATE UNIQUE,
    AnnoEdizioneConferenza INT UNIQUE,
    AcronimoConferenza VARCHAR(20) UNIQUE,
    FOREIGN KEY(GiornoGiornata) REFERENCES GIORNATA(Giorno),
	FOREIGN KEY(AnnoEdizioneConferenza) REFERENCES CONFERENZA(AnnoEdizione),
    FOREIGN KEY(AcronimoConferenza) REFERENCES CONFERENZA(Acronimo)
	) ENGINE=INNODB;
    
create table PRESENTAZIONE(
    Codice INT PRIMARY KEY,
    Inizio TIME,#check(Inizio <(SELECT Fine FROM SESSIONE) AND Inizio >(SELECT INIZIO
                #FROM SESSIONE)),
    Fine TIME, #check(Fine <(SELECT Fine FROM SESSIONE) AND Fine >(SELECT INIZIO
                #FROM SESSIONE)),
    NumeroSequenza INT #all'interno della sessione
    #non si possono avere prestazioni che eccedano l'orario di inizio/fine della sessione

	) ENGINE=INNODB;

create table FORMAZIONE(
	CodiceSessione INT,
    CodicePresentazione INT,
    PRIMARY KEY(CodiceSessione,CodicePresentazione),
    FOREIGN KEY(CodiceSessione) REFERENCES SESSIONE(Codice),
	FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice)
    ) ENGINE=INNODB;

create table ARTICOLO(
	CodicePresentazione INT PRIMARY KEY,
	Titolo VARCHAR(100),
    NumeroPagine INT,
    StatoSvolgimento ENUM("Coperto","Non coperto"),
    UsernameUtente VARCHAR(100),
	FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice)
	) ENGINE=INNODB;
    
    create table PAROLACHIAVE(
    Parola VARCHAR(20),
    CodicePresentazione INT,
    PRIMARY KEY(Parola,CodicePresentazione),
	FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice)
    )ENGINE=INNODB;
    
	
CREATE table AUTORE(
	CodicePresentazione INT,
    Nome VARCHAR(100),
    Cognome VARCHAR(100),
    PRIMARY KEY(CodicePresentazione,Nome,Cognome),
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice)
    ) ENGINE=INNODB;
	
	
create table TUTORIAL(
	CodicePresentazione INT PRIMARY KEY,
    Titolo VARCHAR(100),
    Abstract VARCHAR(500),
	LinkRisorsa VARCHAR(100) DEFAULT NULL,
    DescrizioneRisorsa VARCHAR(100) DEFAULT NULL,
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice)
	) ENGINE=INNODB;
	
create table UTENTE(
    Username VARCHAR(100) PRIMARY KEY,
    Password VARCHAR(100),
    Nome VARCHAR(100),
    Cognome VARCHAR(100),
    DataNascita DATE,
    LuogoNascita VARCHAR(100)
	) ENGINE=INNODB;

create table ISCRIZIONE(
	AnnoEdizioneConferenza INT,
    AcronimoConferenza  VARCHAR(20),
    UsernameUtente VARCHAR(100),
    PRIMARY KEY(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente),
	FOREIGN KEY(AnnoEdizioneConferenza) REFERENCES CONFERENZA(AnnoEdizione),
	FOREIGN KEY(AcronimoConferenza) REFERENCES CONFERENZA(Acronimo),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username)
    ) ENGINE=INNODB;

create table PRESENTER(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
	Curriculum VARCHAR(30),
    Foto LONGBLOB,
    NomeUni VARCHAR(100),
	NomeDipartimento VARCHAR(100),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username)
	) ENGINE=INNODB;

create table SPEAKER(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
	Curriculum VARCHAR(30),
    Foto LONGBLOB,
    NomeUni VARCHAR(100),
	NomeDipartimento VARCHAR(100),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username)
	) ENGINE=INNODB;

create table AMMINISTRATORE(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username)
	) ENGINE=INNODB;

create table VALUTAZIONE(
	Voto INT CHECK(Voto>0 AND Voto<10),
    Note VARCHAR(50)
    ) ENGINE=INNODB;

create table MESSAGGIO(
	CodiceSessione INT,
    UsernameUtente VARCHAR(100),
	DataMessaggio DATE,
    TestoMessaggio VARCHAR(500),
    PRIMARY KEY(CodiceSessione,UsernameUtente),
    FOREIGN KEY(CodiceSessione) REFERENCES SESSIONE(Codice),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username)
	) ENGINE=INNODB;
    
create table DIMOSTRAZIONE(
	UsernameUtente VARCHAR(100),
	CodicePresentazione INT,
    PRIMARY KEY(UsernameUtente,CodicePresentazione),
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username)
    ) ENGINE=INNODB;
    
create table CREAZIONE(
	AnnoEdizioneConferenza INT,
    AcronimoConferenza VARCHAR(20),
    UsernameUtente VARCHAR(100),
    PRIMARY KEY(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente),
    FOREIGN KEY(AnnoEdizioneConferenza) REFERENCES CONFERENZA(AnnoEdizione),
	FOREIGN KEY(AcronimoConferenza) REFERENCES CONFERENZA(Acronimo),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username)
    ) ENGINE=INNODB;
    
create table LISTA(
	UsernameUtente VARCHAR(100),
	CodicePresentazione INT,
    PRIMARY KEY(UsernameUtente,CodicePresentazione),
	FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username),
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice)
    ) ENGINE=INNODB;
    
    #La chat consente l’inserimento di messaggi solo nell’orario
	#di inizio della sessione, e si disattiva immediatamente dopo l’orario di fine della stessa.

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

CREATE VIEW CONFERENZE_DISPONIBILI(Nome,Acronimo,Giorno) AS
	SELECT Nome,Acronimo,Giorno FROM CONFERENZA WHERE(Svolgimento<>"Completato") GROUP BY Giorno;
    

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



CREATE VIEW SESSIONI_PRESENTAZIONI(Sessione,Giorno,Presentazione,Inizio,Fine) AS
	SELECT SESSIONE.Titolo,SESSIONE.GiornoGiornata,PRESENTAZIONE.Codice,PRESENTAZIONE.Inizio,PRESENTAZIONE.Fine FROM SESSIONE,PRESENTAZIONE,FORMAZIONE
    WHERE (FORMAZIONE.CodiceSessione=SESSIONE.Codice AND FORMAZIONE.CodicePresentazione=PRESENTAZIONE.Codice) GROUP BY SESSIONE.Titolo,SESSIONE.GiornoGiornata;



CREATE VIEW VISUALIZZA_MESSAGGI(CodiceSessione,UsernameUtente,TestoMessaggio,DataMessaggio) AS
	SELECT * FROM MESSAGGIO



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





CREATE VIEW NUMERO_CONFERENZE_REGISTRATE(Nome,Numero) AS
	SELECT Nome,COUNT(*) FROM CONFERENZA GROUP BY Nome;

CREATE VIEW NUMERO_CONFERENZE_ATTIVE(Nome,Numero) AS
	SELECT Nome,COUNT(*) FROM CONFERENZA WHERE(Svolgimento="Attiva") GROUP BY Nome;
    

CREATE VIEW NUMERO_UTENTI_REGISTRATI(Username,Numero) AS
	SELECT Username,COUNT(*) FROM UTENTE GROUP BY Username;

#CREATE VIEW CLASSIFICA_SPEAKER_PRESENTER(UsernameUtente,Posizione) AS
#	SELECT UsernameUtente,Voto
/*
#POPOLAMENTO
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Giorno,Svolgimento,TotaleSponsorizzazioni) VALUES ();
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ();
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,NomeSponsor) VALUES ();
INSERT INTO GIORNATA(Giorno,AnnoEdizioneConferenza,AcronimoConferenza) VALUES ();
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) VALUES ();
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES ();
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES ();
INSERT INTO ARTICOLO(CodicePresentazione,Titolo,NumeroPagine,StatoSvolgimento,UsernametUtente) VALUES ();
INSERT INTO PAROLACHIAVE(Parola,CodicePresentazione) VALUES ();
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES ();
INSERT INTO TUTORIAL(CodicePresentazione,Titolo,Abstract,LinkRisorsa,DescirzioneRisorsa) VALUES ();
INSERT INTO UTENTE(Username,Password,Nome,Cognome,DataNascita,LuogoNascita) VALUES ();
INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente) VALUES ();
INSERT INTO PRESENTER(UsernameUtente,Curriculum,Foto,NomeUni,NomeDipartimento) VALUES ();
INSERT INTO SPEAKER(UsernameUtente,Curriculum,Foto,NomeUni,NomeDipartimento) VALUES ();
INSERT INTO AMMINISTRATORE(UsernameUtente) VALUES ();
INSERT INTO VALUTAZIONE(Voto,Note) VALUES ();
INSERT INTO CHAT(CodiceSessione,UsernameUtente,DataMessaggio,TestoMessaggio) VALUES ();
INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ();
INSERT INTO CREAZIONE(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente) VALUES ();
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ();


    	