DROP DATABASE IF EXISTS CONFVIRTUAL;
CREATE DATABASE CONFVIRTUAL;
USE CONFVIRTUAL;

CREATE TABLE CONFERENZA(
	AnnoEdizione INT DEFAULT 2000,
    Acronimo VARCHAR(20),
    Nome VARCHAR(100),
    Logo VARCHAR(100),
    Svolgimento ENUM("Attiva", "Completata") DEFAULT "Attiva",
    TotaleSponsorizzazioni INT DEFAULT 0,
    PRIMARY KEY(AnnoEdizione,Acronimo)
    #collegare totaleSponsorizzazioni al numero di sposor collegati
) ENGINE=INNODB;

CREATE TABLE SPONSOR(
	Nome VARCHAR(100) PRIMARY KEY,
	Logo VARCHAR(100),
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
    NumeroPresentazioni INT DEFAULT 0, 
    Inizio TIME,
    Fine TIME,
    Link VARCHAR(100),
    GiornoGiornata DATE,
    AnnoEdizioneConferenza INT,
    AcronimoConferenza VARCHAR(20),
	FOREIGN KEY(AnnoEdizioneConferenza, AcronimoConferenza) REFERENCES CONFERENZA(AnnoEdizione, Acronimo) ON DELETE CASCADE,
    FOREIGN KEY(GiornoGiornata) REFERENCES GIORNATA(Giorno) ON DELETE CASCADE
    #collegare NumeroPresentazioni al numero di presentazioni collegate
) ENGINE=INNODB;
    
CREATE TABLE PRESENTAZIONE(
    Codice INT PRIMARY KEY,
    Inizio TIME,
    Fine TIME,
    NumeroSequenza INT 
    #non si possono avere prestazioni che eccedano orario di inizio/fine della sessione
    #PRESENTAZIONE.Inizio >= SESSIONE.Inizio 
    #PRESENTAZIONE.Fine <= SESSIONE.Fine 
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
    StatoSvolgimento ENUM("Coperto", "Non coperto") DEFAULT "Non coperto",
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
	Curriculum VARCHAR(30) DEFAULT NULL,
    Foto VARCHAR(100) DEFAULT NULL,
    NomeUni VARCHAR(100) DEFAULT NULL,
	NomeDipartimento VARCHAR(100) DEFAULT NULL,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE DIMOSTRAZIONE(
	UsernameUtente VARCHAR(100),
	CodicePresentazione INT,
    PRIMARY KEY(UsernameUtente,CodicePresentazione),
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE RISORSA(
	UsernameUtente VARCHAR(100),
	CodicePresentazione INT,
	LinkRisorsa VARCHAR(100),
    DescrizioneRisorsa VARCHAR(100),
    PRIMARY KEY(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa),
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE PRESENTER(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
	Curriculum VARCHAR(30) DEFAULT NULL,
    Foto VARCHAR(100) DEFAULT NULL,
    NomeUni VARCHAR(100) DEFAULT NULL,
	NomeDipartimento VARCHAR(100) DEFAULT NULL,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
    #Un presenter deve essere necessariamente uno degli autori dell’articolo
) ENGINE=INNODB;

CREATE TABLE AMMINISTRATORE(
	UsernameUtente VARCHAR(100) PRIMARY KEY,
    FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE
    #All’atto della creazione di una nuova conferenza, l’amministratore è anche automaticamente registrato alla stessa
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
    #La chat consente l’inserimento di messaggi solo nell’orario di inizio della sessione, 
    #e si disattiva immediatamente dopo l’orario di fine della stessa.
) ENGINE=INNODB;
    
CREATE TABLE LISTA(
	UsernameUtente VARCHAR(100),
	CodicePresentazione INT,
    PRIMARY KEY(UsernameUtente,CodicePresentazione),
	FOREIGN KEY(UsernameUtente) REFERENCES UTENTE(Username) ON DELETE CASCADE,
    FOREIGN KEY(CodicePresentazione) REFERENCES PRESENTAZIONE(Codice) ON DELETE CASCADE
) ENGINE=INNODB;




INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "ICSI", "International Conference on Swarm Intelligence", "icsi.png", "Attiva", 2);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "FRUCT", "IEEE FRUCT Conference", "fruct.png", "Completata", 1);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "AIVR", "Conference on Artificial Intelligence and Virtual Reality", "aivr.jpg", "Attiva", 1);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2021, "CogSIMA", " Conference on Cognitive and Computational Aspects of Situation Management", "cogsima.jpg", "Completata", 0);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "WIT", "Workshop On Deriving Insights From User-Generated Text", "wit.jpg", "Attiva", 1);
INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo,Svolgimento,TotaleSponsorizzazioni) 
	VALUES (2022, "SPNLP", "Workshop on Structured Prediction for NLP", "spnlp.png", "Attiva", 2);
    
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

INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Mastercard", "mastercard.webp", 1000000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("PlayStation", "playstation.jpeg", 500000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("FedEx", "Fedex.png", 1500000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Adidas", "adidas.jpeg", 275000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Nike", "nike.png", 750000);
INSERT INTO SPONSOR(Nome,Logo,Importo) VALUES ("Visa", "visa.png", 1250000);

INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "ICSI", "FedEx");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "ICSI", "Adidas");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "FRUCT", "Visa");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "AIVR", "FedEx");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "WIT", "Mastercard");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "SPNLP", "PlayStation");
INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES (2022, "SPNLP", "Nike");

INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Mari", "Mari", "Marianna", "Gimigliano", "2000-10-13", "Cesena");
INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("PietroL", 111, "Pietro", "Lelli", "2000-03-06", "Cesena");
INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Francesco1", "ciao", "Francesco", "Montanari", "2000-03-22", "Bologna");
INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Giacomo00", 1234, "Giacomo", "Fantato", "2000-01-12", "Bologna");
INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Luca", "luca1", "Luca", "Rossi", "1998-02-16", "Milano");
INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Paola30", "ciao", "Paola", "Ricci", "2001-10-30", "Bologna");
INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES ("Lucia", "lucia", "Lucia", "Verdi", "1999-11-04", "Milano");

INSERT INTO SPEAKER(UsernameUtente, Curriculum, Foto, NomeUni, NomeDipartimento) VALUES ("PietroL", null, null, null, null);
INSERT INTO SPEAKER(UsernameUtente, Curriculum, Foto, NomeUni, NomeDipartimento) VALUES ("Luca", null, null, null, null);

INSERT INTO PRESENTER(UsernameUtente, Curriculum, Foto, NomeUni, NomeDipartimento) VALUES ("Francesco1", null, null, null, null);
INSERT INTO PRESENTER(UsernameUtente, Curriculum, Foto, NomeUni, NomeDipartimento) VALUES ("Paola30", null, null, null, null);

INSERT INTO AMMINISTRATORE(UsernameUtente) VALUES ("Mari");
INSERT INTO AMMINISTRATORE(UsernameUtente) VALUES ("Lucia");

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
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (104, "10:00:00","11:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (105, "11:00:00","12:00:00", 02);

INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100151, 101);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100152, 102);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100152, 103);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100153, 104);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100153, 105);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100154, 102);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (100155, 104);

INSERT INTO ARTICOLO(CodicePresentazione, Titolo, NumeroPagine, StatoSvolgimento, UsernameUtente) VALUES (101, "Articolo1_ICSI", 15, "Coperto", "Francesco1");
INSERT INTO ARTICOLO(CodicePresentazione, Titolo, NumeroPagine, StatoSvolgimento, UsernameUtente) VALUES (102, "Articolo2_ICSI", 30, "Non Coperto", null);
INSERT INTO ARTICOLO(CodicePresentazione, Titolo, NumeroPagine, StatoSvolgimento, UsernameUtente) VALUES (103, "Articolo3_ICSI", 23, "Coperto", "Paola30");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (104, "Tutorial1_ICSI", "aaa");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (105, "Tutorial2_ICSI", "aaa");

INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("PietroL", 104);
INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("Luca", 105);

INSERT INTO RISORSA(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES ("Luca", 105, "www.tutorial2.com", "aaa");

INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (101, "Controllo");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (101, "Classificazione");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (102, "Ottimizzazione");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (102, "Processo");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (102, "Componenti ottici");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (103, "Sistemi");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (103, "Algoritmo");

INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (101, "Francesco", "Montanari");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (102, "Paola", "Ricci");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (102, "Marco", "Mazzotti");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (103, "Paola", "Ricci");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (103, "Filippo", "Magnani");

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

INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (201, "Tutorial1_AIVR", "aaa");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (202, "Tutorial2_AIVR", "aaa");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (203, "Tutorial3_AIVR", "aaa");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (204, "Tutorial4_AIVR", "aaa");

INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("PietroL", 201);
INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("Luca", 202);
INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("Luca", 203);
INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("Luca", 204);

INSERT INTO RISORSA(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES ("Luca", 202, "www.tutorial2.com", "aaa");
INSERT INTO RISORSA(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES ("PietroL", 201, "www.tutorial1.com", "aaa");
INSERT INTO RISORSA(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES ("PietroL", 201, "www.tutorial1_2.com", "aaa");

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

INSERT INTO ARTICOLO(CodicePresentazione, Titolo, NumeroPagine, StatoSvolgimento, UsernameUtente) VALUES (301, "Articolo1_WIT", 20, "Non Coperto", null);
INSERT INTO ARTICOLO(CodicePresentazione, Titolo, NumeroPagine, StatoSvolgimento, UsernameUtente) VALUES (302, "Articolo2_WIT", 5, "Non Coperto", null);
INSERT INTO ARTICOLO(CodicePresentazione, Titolo, NumeroPagine, StatoSvolgimento, UsernameUtente) VALUES (303, "Articolo3_WIT", 14, "Coperto", "Francesco1");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (304, "Tutorial1_WIT", "aaa");

INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("PietroL", 304);

INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (301, "Conteggio");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (301, "Classificazione");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (302, "Qualità");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (302, "Processo");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (303, "Scanner 3D");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (303, "Robot");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (303, "Scansioni lienari");

INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (301, "Francesco", "Montanari");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (301, "Laura", "Bianchi");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (301, "Sofia", "Balzani");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (302, "Paola", "Ricci");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (302, "Lorenzo", "Antonelli");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (303, "Francesco", "Montanari");

INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400527,"Mattina 27/05 SPNLP", 1,"9:00:00","12:00:00","www.SPNLP_mattina1.it","2022-05-27",2022, "SPNLP");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400528,"Pomeriggio 27/05 SPNLP", 1,"14:00:00","18:00:00","www.SPNLP_pomeriggio1.it","2022-05-27",2022, "SPNLP");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400529,"Mattina 28/05 SPNLP", 2,"9:00:00","12:00:00","www.SPNLP_mattina2.it","2022-05-28",2022, "SPNLP");
INSERT INTO SESSIONE(Codice,Titolo,NumeroPresentazioni,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
VALUES (400530,"Pomeriggio 28/05 SPNLP",1,"14:00:00","18:00:00","www.SPNLP_pomeriggio2.it","2022-05-28",2022, "SPNLP");

INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (401, "09:00:00","10:30:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (402, "14:00:00","18:00:00", 01);
INSERT INTO PRESENTAZIONE(Codice,Inizio,Fine,NumeroSequenza) VALUES (403, "10:30:00","12:00:00", 02);

INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400527, 401);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400528, 402);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400529, 401);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400530, 403);
INSERT INTO FORMAZIONE(CodiceSessione,CodicePresentazione) VALUES (400530, 402);

INSERT INTO ARTICOLO(CodicePresentazione, Titolo, NumeroPagine, StatoSvolgimento, UsernameUtente) VALUES (401, "Articolo1_SPNLP", 18, "Coperto", "Paola30");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (402, "Tutorial1_SPNLP", "aaa");
INSERT INTO TUTORIAL(CodicePresentazione, Titolo, Abstract) VALUES (403, "Tutorial2_SPNLP", "aaa");

INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (401, "Paola", "Ricci");
INSERT INTO AUTORE(CodicePresentazione,Nome,Cognome) VALUES (401, "Mattia", "Giunchi");

INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (401, "Misurazioni");
INSERT INTO PAROLACHIAVE(CodicePresentazione,Parola) VALUES (402, "Deeplearning");

INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("Luca", 402);
INSERT INTO DIMOSTRAZIONE(UsernameUtente,CodicePresentazione) VALUES ("Luca", 403);

INSERT INTO RISORSA(UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES ("Luca", 402, "www.tutorial2.com", "aaa");

INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "SPNLP", "Mari");
INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "WIT", "Francesco1");
INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "WIT", "Giacomo00");

INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (401, "Mari", 8, "Interessante");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (403, "Lucia", 3, "Noiosa");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (403, "Mari", 4, "Poco chiara");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (401, "Lucia", 9, "Molto bravo il presenter");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (303, "Lucia", 3, "Noiosa");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (304, "Mari", 4, "Poco chiara");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (201, "Lucia", 9, "Molto bravo il presenter");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (202, "Lucia", 9, "Molto bravo il presenter");
INSERT INTO VALUTAZIONE(CodicePresentazione, UsernameUtente, Voto, Note) VALUES (101, "Lucia", 9, "Molto bravo il presenter");

INSERT INTO CREAZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "ICSI", "Mari");
INSERT INTO CREAZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "FRUCT", "Mari");
INSERT INTO CREAZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "AIVR", "Lucia");
INSERT INTO CREAZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2021, "CogSIMA", "Lucia");
INSERT INTO CREAZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "WIT", "Mari");
INSERT INTO CREAZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (2022, "SPNLP", "Lucia");

INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Mari", 302);
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Mari", 204);
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Francesco1", 102);
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Giacomo00", 302);
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Giacomo00", 401);
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Giacomo00", 204);
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Luca", 103);
INSERT INTO LISTA(UsernameUtente,CodicePresentazione) VALUES ("Luca", 303);


/*OPERAZIONI UTENTI GENERICI*/

#Registrazione nuovo utente
DELIMITER $
CREATE PROCEDURE REGISTRAZIONE(IN UsernameI VARCHAR(100), IN PasswordI VARCHAR(100), IN NomeI VARCHAR(100),
	IN CognomeI VARCHAR(100), IN DataNascitaI DATE, IN LuogoNascitaI VARCHAR(100))
BEGIN 
	DECLARE UsernameX VARCHAR(100);
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
	DECLARE AnnoEdizioneConferenzaX INT;
    DECLARE AcronimoConferenzaX INT;
    DECLARE UsernameUtenteX VARCHAR(100);
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
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE CodiceSessioneX INT;
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
	DECLARE UsernameUtenteX VARCHAR(100);
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
	DECLARE AnnoEdizioneX INT;
    DECLARE AcronimoX VARCHAR(20);
	SET AnnoEdizioneX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneI AND Acronimo=AcronimoI));
	SET AcronimoX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneI AND Acronimo=AcronimoI));
	IF(AnnoEdizioneX<>1 AND AcronimoX<>1) THEN
		INSERT INTO CONFERENZA(AnnoEdizione,Acronimo,Nome,Logo) 
        VALUES (AnnoEdizioneI,AcronimoI,NomeI,LogoI);
	END IF;
END $
DELIMITER ;

#NON FUNZIONA !!!!!!!!!!!!!!!!!!!!!!
#Creazione di una nuova sessione della conferenza
DELIMITER $
CREATE PROCEDURE CREAZIONE_SESSIONE(IN CodiceI INT, IN TitoloI VARCHAR(100), IN InizioI TIME, 
	IN FineI TIME, IN LinkI VARCHAR(100), IN GiornoGiornataI DATE, IN AnnoEdizioneConferenzaI INT, 
    IN AcronimoConferenzaI VARCHAR(20))
BEGIN
	DECLARE GiornoGiornataX DATE;
    DECLARE AnnoEdizioneX INT;
    DECLARE AcronimoX VARCHAR(20);
    SET AnnoEdizioneX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
	SET AcronimoX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
    SET GiornoGiornataX =(SELECT COUNT(*) FROM GIORNATA WHERE(Giorno=GiornoGiornataI AND AnnoEdizioneConferenza=AnnoEdizioneConferenzaI AND AcronimoConferenza=AcronimoConferenzaI));
    IF(AnnoEdizioneX=1 AND AcronimoX=1 AND GiornoGiornataX=1) THEN
		INSERT INTO SESSIONE(Codice,Titolo,Inizio,Fine,Link,GiornoGiornata,AnnoEdizioneConferenza,AcronimoConferenza) 
		VALUES (CodiceI,TitoloI,InizioI,FineI,LinkI,GiornoGiornataI,AnnoEdizioneConferenzaI,AcronimoConferenzaI);
    END IF;
END $
DELIMITER ;

#Inserimento delle presentazioni in una sessione
DELIMITER $
CREATE PROCEDURE INSERIMENTO_PRESENTAZIONI(IN CodiceSessioneI INT, IN CodicePresentazioneI INT)
BEGIN
	DECLARE CodiceSessioneX INT;
    DECLARE CodicePresentazioneX INT;
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
	DECLARE UsernameUtenteX VARCHAR(100);
    DECLARE CodicePresentazioneX INT;
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
	DECLARE UsernameUtenteX VARCHAR(100);
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
	DECLARE UsernameUtenteX VARCHAR(100);
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
	DECLARE AnnoEdizioneConferenzaX INT;
    DECLARE AcronimoConferenzaX INT;
    DECLARE NomeSponsorX VARCHAR(100);
    SET AnnoEdizioneConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
	SET AcronimoConferenzaX =(SELECT COUNT(*) FROM CONFERENZA WHERE(AnnoEdizione=AnnoEdizioneConferenzaI AND Acronimo=AcronimoConferenzaI));
    SET NomeSponsorX =(SELECT COUNT(*) FROM SPONSOR WHERE(Nome=NomeSponsorI));
	IF(AnnoEdizioneConferenzaX=1 AND AcronimoConferenzaX=1 AND NomeSponsorX=1) THEN
		INSERT INTO DISPOSIZIONE(AnnoEdizioneConferenza,AcronimoConferenza,NomeSponsor) VALUES
		(AnnoEdizioneConferenzaI,AcronimoConferenzaI,NomeSponsorI);
	END IF;
END $
DELIMITER ;


CALL CREAZIONE_SESSIONE(1, "x", "10:30:00", "11:00:00", "x", "2022-04-02" ,2022, "WIT");
SELECT * FROM SESSIONE;

CAll INSERIMENTO_SPONSOR(2022, "ICSI", "Nike");
SELECT * FROM DISPOSIZIONE;

CALL INSERIMENTO_VALUTAZIONE(101,"Mari", 2, "x");
SELECT * FROM VALUTAZIONE;

CALL ASSOCIAZIONE_PRESENTER("Francesco1", 102);
SELECT * FROM ARTICOLO;

CALL ASSOCIAZIONE_SPEAKER("Luca", 104);
SELECT * FROM DIMOSTRAZIONE;

CALL INSERIMENTO_PRESENTAZIONI(3002, 302);
SELECT * FROM FORMAZIONE;

CALL REGISTRAZIONE("x", "ciao", "x", "x", "2000-03-03", "x");
SELECT * FROM UTENTE;

CALL REGISTRAZIONE_CONFERENZA(2022, "WIT", "Mari");
SELECT * FROM ISCRIZIONE;

CALL INSERIMENTO_FAVORITA("PietroL", 203);
SELECT * FROM LISTA;

CALL CREAZIONE_CONFERENZA(2022, "x", "x", "x");
SELECT * FROM CONFERENZA;


