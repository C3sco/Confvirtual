/* STRUTTURA */

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
