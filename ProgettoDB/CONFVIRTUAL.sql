DROP DATABASE IF EXISTS CONFVIRTUAL;
CREATE DATABASE CONFVIRTUAL;
USE CONFVIRTUAL;

CREATE TABLE CONFERENZA(
	AnnoEdizione INT DEFAULT 2000,
    Acronimo VARCHAR(20),
    Nome VARCHAR(100),
    Logo CHAR,
    Svolgimento ENUM("Attiva", "Completata"),
    TotaleSponsorizzazioni INT DEFAULT 0,
    PRIMARY KEY(AnnoEdizione,Acronimo)
) ENGINE=INNODB;

CREATE TABLE SPONSOR(
	Nome VARCHAR(100) PRIMARY KEY,
	Logo Char,
	Importo DOUBLE
) ENGINE=INNODB;
    
CREATE TABLE DISPOSIZIONE(
	AnnoEdizioneConferenza INT DEFAULT 2000,
    AcronimoConferenza VARCHAR(20),
    NomeSponsor VARCHAR(100),
    PRIMARY KEY (AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor),
	FOREIGN KEY(AnnoEdizioneConferenza, AcronimoConferenza) REFERENCES CONFERENZA(AnnoEdizione, Acronimo) ON DELETE CASCADE,
    FOREIGN KEY(NomeSponsor) REFERENCES SPONSOR(Nome) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE GIORNATA(
    AnnoEdizioneConferenza INT,
    AcronimoConferenza VARCHAR(20),
    Giorno DATE UNIQUE,
    PRIMARY KEY(AnnoEdizioneConferenza,AcronimoConferenza,Giorno),
	FOREIGN KEY(AnnoEdizioneConferenza, AcronimoConferenza) REFERENCES CONFERENZA(AnnoEdizione, Acronimo) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE SESSIONE(
    Codice INT PRIMARY KEY,
    Titolo VARCHAR(100),
    NumeroPresentazioni INT DEFAULT 0,  #da collegare
    Inizio TIME, #check(Inizio>Fine),
    Fine TIME, #check(Fine<Inizio),
    Link VARCHAR(100),
    GiornoGiornata DATE,
    AnnoEdizioneConferenza INT,
    AcronimoConferenza VARCHAR(20),
	FOREIGN KEY(AnnoEdizioneConferenza, AcronimoConferenza) REFERENCES CONFERENZA(AnnoEdizione, Acronimo) ON DELETE CASCADE,
    FOREIGN KEY(GiornoGiornata) REFERENCES GIORNATA(Giorno) ON DELETE CASCADE
) ENGINE=INNODB;
    
CREATE TABLE PRESENTAZIONE(
    Codice INT PRIMARY KEY,
    Inizio TIME,#check(Inizio <(SELECT Fine FROM SESSIONE) AND Inizio >(SELECT INIZIO FROM SESSIONE)),
    Fine TIME, #check(Fine <(SELECT Fine FROM SESSIONE) AND Fine >(SELECT INIZIO FROM SESSIONE)),
    NumeroSequenza INT #all'interno della sessione
    #non si possono avere prestazioni che eccedano l'orario di inizio/fine della sessione
) ENGINE=INNODB;

CREATE TABLE FORMAZIONE(
	CodiceSessione INT,
    CodicePresentazione INT,
    PRIMARY KEY(CodiceSessione,CodicePresentazione),
    FOREIGN KEY(CodiceSessione) REFERENCES SESSIONE(Codice) ON DELETE CASCADE,
	FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE
) ENGINE=INNODB;
	
CREATE TABLE UTENTE(
    Username VARCHAR(100) PRIMARY KEY,
    Passwordd VARCHAR(100),
    Nome VARCHAR(100),
    Cognome VARCHAR(100),
    DataNascita DATE,
    LuogoNascita VARCHAR(100)
) ENGINE=INNODB;

CREATE TABLE ARTICOLO(
	CodicePresentazione INT PRIMARY KEY,
	Titolo VARCHAR(100),
    NumeroPagine INT,
    StatoSvolgimento ENUM("Coperto", "Non coperto"),
    UsernameUtente VARCHAR(100),
	FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE AUTORE(
	CodicePresentazione INT,
    Nome VARCHAR(100),
    Cognome VARCHAR(100),
    PRIMARY KEY(CodicePresentazione,Nome,Cognome),
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE PAROLACHIAVE(
    Parola VARCHAR(20),
    CodicePresentazione INT,
    PRIMARY KEY(Parola,CodicePresentazione),
	FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE
)ENGINE=INNODB;
		
CREATE TABLE TUTORIAL(
	CodicePresentazione INT PRIMARY KEY,
    Titolo VARCHAR(100),
    Abstract VARCHAR(500),
	LinkRisorsa VARCHAR(100) DEFAULT NULL,
    DescrizioneRisorsa VARCHAR(100) DEFAULT NULL,
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE ISCRIZIONE(
	AnnoEdizioneConferenza INT,
    AcronimoConferenza  VARCHAR(20),
    UsernameUtente VARCHAR(100),
    PRIMARY KEY(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente),
	FOREIGN KEY(AnnoEdizioneConferenza, AcronimoConferenza) REFERENCES CONFERENZA(AnnoEdizione, Acronimo) ON DELETE CASCADE,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE SPEAKER(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
	Curriculum VARCHAR(30),
    Foto LONGBLOB,
    NomeUni VARCHAR(100),
	NomeDipartimento VARCHAR(100),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE DIMOSTRAZIONE(
	UsernameUtente VARCHAR(100),
	CodicePresentazione INT,
    PRIMARY KEY(UsernameUtente,CodicePresentazione),
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE PRESENTER(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
	Curriculum VARCHAR(30),
    Foto LONGBLOB,
    NomeUni VARCHAR(100),
	NomeDipartimento VARCHAR(100),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE AMMINISTRATORE(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE VALUTAZIONE(
	CodicePresentazione INT,
    UsernameUtente VARCHAR(100),
	Voto INT CHECK(Voto>0 AND Voto<10),
    Note VARCHAR(100),
    PRIMARY KEY(UsernameUtente,CodicePresentazione),
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE,
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE CREAZIONE(
	AnnoEdizioneConferenza INT,
    AcronimoConferenza VARCHAR(20),
    UsernameUtente VARCHAR(100),
    PRIMARY KEY(AnnoEdizioneConferenza,AcronimoConferenza,UsernameUtente),
	FOREIGN KEY(AnnoEdizioneConferenza, AcronimoConferenza) REFERENCES CONFERENZA(AnnoEdizione, Acronimo) ON DELETE CASCADE,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE MESSAGGIO(
	CodiceSessione INT,
    UsernameUtente VARCHAR(100),
	DataMessaggio DATE,
    TestoMessaggio VARCHAR(500),
    PRIMARY KEY(CodiceSessione,UsernameUtente,DataMessaggio,TestoMessaggio),
    FOREIGN KEY(CodiceSessione) REFERENCES SESSIONE(Codice) ON DELETE CASCADE,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
    #La chat consente l’inserimento di messaggi solo nell’orario
	#di inizio della sessione, e si disattiva immediatamente dopo l’orario di fine della stessa.
) ENGINE=INNODB;
    
CREATE TABLE LISTA(
	UsernameUtente VARCHAR(100),
	CodicePresentazione INT,
    PRIMARY KEY(UsernameUtente,CodicePresentazione),
	FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE,
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE
) ENGINE=INNODB;




INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "ICSI", "International Conference on Swarm Intelligence", "x", "Attiva", 2);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "FRUCT", "IEEE FRUCT Conference", "x", "Completata", 1);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "AIVR", "Conference on Artificial Intelligence and Virtual Reality", "x", "Attiva", 1);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2021, "CogSIMA", " Conference on Cognitive and Computational Aspects of Situation Management", "x", "Completata", 0);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "WIT", "Workshop On Deriving Insights From User-Generated Text", "x", "Attiva", 1);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "SPNLP", "Workshop on Structured Prediction for NLP", "x", "Attiva", 2);
    
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "ICSI", "2022-03-15");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "ICSI", "2022-03-16");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "ICSI", "2022-03-17");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "FRUCT", "2022-01-05");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "AIVR", "2022-06-22");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "AIVR", "2022-06-23");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2021, "CogSIMA", "2021-12-03");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "WIT", "2022-04-02");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "WIT", "2022-04-03");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "WIT", "2022-04-04");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "SPNLP", "2022-05-27");
INSERT INTO GIORNATA(AnnoEdizioneConferenza,AcronimoConferenza, Giorno) VALUES (2022, "SPNLP", "2022-05-28");

INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Mastercard", "x", 1000000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("PlayStation", "x", 500000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("FedEx", "x", 1500000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Adidas", "x", 275000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Nike", "x", 750000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Visa", "x", 1250000);

INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "ICSI", "FedEx");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "ICSI", "Adidas");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "FRUCT", "Visa");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "AIVR", "FedEx");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "WIT", "Mastercard");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "SPNLP", "PlayStation");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "SPNLP", "Nike");

INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Mari", "Mari", "Marianna", "Gimigliano", "2000-10-13", "Cesena");
INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Pietro1", 111, "Pietro", "Lelli", "2000-03-06", "Cesena");

INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (100151,"Mattina 15/03 ICSI", 1,"9:00:00","12:00:00","www.ICSI_mattina1.it","2022-03-15",2022, "ICSI");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (100152,"Pomeriggio 15/03 ICSI", 2,"14:00:00","18:00:00","www.ICSI_pomeriggio2.it","2022-03-15",2022, "ICSI");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (100153,"Mattina 16/03 ICSI", 2,"9:00:00","12:00:00","www.ICSI_mattina2.it","2022-03-16",2022, "ICSI");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (100154,"Pomeriggio 16/03 ICSI",1,"14:00:00","17:00:00","www.ICSI_pomeriggio2.it","2022-03-17",2022, "ICSI");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (100155,"Mattina 17/03 ICSI",1,"10:00:00","12:00:00","www.ICSI_mattina3.it","2022-03-17",2022, "ICSI");

INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (101, "9:00:00","12:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (102, "14:00:00","16:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (103, "16:00:00","18:00:00", 02);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (104, "9:00:00","11:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (105, "11:00:00","12:00:00", 02);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (106, "14:00:00","17:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (107, "10:00:00","12:00:00", 01);

INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100151, 101);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100152, 102);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100152, 103);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100153, 104);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100153, 105);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100154, 106);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100155, 107);

INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (200622,"Giornata 22/06 AIVR",2,"10:00:00","16:00:00","www.AIVR_giornata1.it","2022-06-22",2022, "AIVR");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (200623,"Giornata 23/06 AIVR",2,"10:00:00","17:00:00","www.AIVR_giornata2.it","2022-06-23",2022, "AIVR");

INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (201, "10:00:00","13:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (202, "13:00:00","16:00:00", 02);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (203, "10:00:00","13:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (204, "14:00:00","17:00:00", 02);

INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (200622, 201);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (200622, 202);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (200623, 203);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (200623, 204);

INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (3002,"Giornata 02/04 WIT",1,"12:00:00","17:00:00","www.WIT_giornata1.it","2022-04-02",2022, "WIT");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (3003,"Giornata 03/04 WIT",1,"14:00:00","18:00:00","www.WIT_giornata2.it","2022-04-03",2022, "WIT");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (3004,"Giornata 04/04 WIT",2,"10:00:00","18:00:00","www.WIT_giornata3.it","2022-04-04",2022, "WIT");

INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (301, "12:00:00","17:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (302, "14:00:00","16:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (303, "10:00:00","12:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (304, "14:00:00","18:00:00", 02);

INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (3002, 301);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (3003, 302);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (3004, 303);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (3004, 304);

INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400527,"Mattina 27/05 SPNLP", 1,"9:00:00","12:00:00","www.SPNLP_mattina1.it","2022-05-27",2022, "SPNLP");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400528,"Pomeriggio 27/05 SPNLP", 1,"14:00:00","18:00:00","www.SPNLP_pomeriggio1.it","2022-05-27",2022, "SPNLP");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400529,"Mattina 28/05 SPNLP", 2,"9:00:00","12:00:00","www.SPNLP_mattina2.it","2022-05-28",2022, "SPNLP");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400530,"Pomeriggio 28/05 SPNLP",1,"14:00:00","18:00:00","www.SPNLP_pomeriggio2.it","2022-05-28",2022, "SPNLP");

INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (401, "9:00:00","12:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (402, "14:00:00","18:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (403, "9:00:00","10:30:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (404, "10:30:00","12:00:00", 02);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (405, "14:00:00","18:00:00", 01);

INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400527, 401);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400528, 402);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400529, 403);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400530, 404);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400530, 405);


CREATE VIEW CONFERENZE_DISPONIBILI(Nome,Acronimo,AnnoEdizione,Logo,Giorno) AS 
SELECT Nome,Acronimo,AnnoEdizione,Logo,Giorno FROM CONFERENZA, GIORNATA 
WHERE (Acronimo=AcronimoConferenza) AND (AnnoEdizione=AnnoEdizioneConferenza) AND (Svolgimento<>"Completata")





