<?php
    class DatabaseHelper{
        
        private $db;
    
        public function __construct($servername, $username, $password, $dbname, $port){
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }        
        }


        //----------------------------------------------------------------------------------------
        //STATISTICHE PAGINA INIZIALE

        //numero totale conferenze
        public function getNumConferenze(){
            $query = "SELECT COUNT(*) as NumConf FROM CONFERENZA";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //numero totale conferenze attive
        public function getNumConferenzeAttive(){
            $attiva = "Attiva";
            $query = "SELECT COUNT(*) as NumConfAtt FROM CONFERENZA WHERE Svolgimento=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $attiva);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //numero totale utenti
        public function getNumUtenti(){
            $query = "SELECT COUNT(*) as NumUtenti FROM UTENTE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } 

        //voto medio presenter
        public function avgVotoPresenter(){
            $query = "SELECT ARTICOLO.UsernameUtente, AVG(Voto) AS Media FROM VALUTAZIONE, ARTICOLO WHERE ARTICOLO.CodicePresentazione=VALUTAZIONE.CodicePresentazione GROUP BY ARTICOLO.UsernameUtente ORDER BY Media DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } 

        //voto medio speaker
        public function avgVotoSpeaker(){
            $query = "SELECT DIMOSTRAZIONE.UsernameUtente, AVG(Voto) AS Media FROM VALUTAZIONE, DIMOSTRAZIONE WHERE DIMOSTRAZIONE.CodicePresentazione=VALUTAZIONE.CodicePresentazione GROUP BY DIMOSTRAZIONE.UsernameUtente ORDER BY Media DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } 


        //----------------------------------------------------------------------------------------
        //OPERAZIONI UTENTI GENERICI

        //utenti by username - per login
        public function getUtente($username){
            $query = "SELECT * FROM UTENTE WHERE Username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce nuovo utente per registrazione
        public function insertUser($username, $password, $nome, $cognome, $datanascita, $luogonascita){
            $query= "CALL REGISTRAZIONE (?,?,?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssssss', $username, $password, $nome, $cognome, $datanascita, $luogonascita);
            $stmt->execute();
        }

        //inserisce nuovo utente amministratore
        public function insertAmministratore($username){
            $query= "CALL REGISTRAZIONE_AMMINISTRATORE (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
        }

        //inserisce nuovo utente speaker
        public function insertSpeaker($username){
            $query= "CALL REGISTRAZIONE_SPEAKER (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
        }

        //inserisce nuovo utente presenter
        public function insertPresenter($username){
            $query= "CALL REGISTRAZIONE_PRESENTER (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
        }

        //visualizza tutte le conferenze
        public function getConferenze(){
            $query = "SELECT DISTINCT Nome, Acronimo, AnnoEdizione, Logo, TotaleSponsorizzazioni FROM CONFERENZA WHERE Svolgimento=?";
            $stmt = $this->db->prepare($query);
            $attiva = "Attiva";
            $stmt->bind_param('s',$attiva);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //iscrive utente ad una conferenza
        public function insertIscrizione($annoEdizioneConferenza, $acronimoConferenza, $usernameUtente){
            $query= "CALL REGISTRAZIONE_CONFERENZA(?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $annoEdizioneConferenza, $acronimoConferenza, $usernameUtente);
            $stmt->execute();
        }

        //visualizza sessioni della conferenza selezionata
        public function getSessionibyConferenza($acronimoConf){
            $query = "SELECT * FROM SESSIONE WHERE AcronimoConferenza=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$acronimoConf);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //visualizza presentazioni della sessione selezionata
        public function getPresentazioniBySessione($codiceSessione){
            $query = "SELECT * FROM SESSIONE, FORMAZIONE, PRESENTAZIONE WHERE SESSIONE.Codice=CodiceSessione AND PRESENTAZIONE.Codice=CodicePresentazione AND CodiceSessione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codiceSessione);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //visualizza lista presentazioni preferite dell'utente
        public function getListaByUsername($username){
            $query = "SELECT * FROM LISTA WHERE UsernameUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce presentazione nella lista presentazioni preferite dell'utente
        public function insertLista($username, $codicePres){
            $query= "CALL INSERIMENTO_FAVORITA (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $username, $codicePres);
            $stmt->execute();
        } 


        //----------------------------------------------------------------------------------------
        //OPERAZIONI AMMINISTRATORE

        //inserisce nuova conferenza
        public function insertConferenza($anno, $acronimo, $nome, $logo){
            $query= "CALL CREAZIONE_CONFERENZA (?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('isss', $anno, $acronimo, $nome, $logo);
            $stmt->execute();
        }

        //inserisce giorni di una conferenza 
        public function insertDataConferenza($acronimo, $anno, $data){
            $query= "CALL INSERIMENTO_GIORNO (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $anno, $acronimo, $data);
            $stmt->execute();
        }

        //inserisce relazione di creazione della conferenza
        public function insertCreazioneConf($anno, $acronimo, $username){
            $query= "CALL INSERIMENTO_CREAZIONE (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $anno, $acronimo, $username);
            $stmt->execute();
        }  

        //per mantenere chiavi della conf selezionata
        public function getConferenzaByNome($nome){
            $query = "SELECT AnnoEdizione, Acronimo, Nome FROM CONFERENZA WHERE Nome=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$nome);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce nuova sessione 
        public function insertSessione($codice, $titolo, $inizio, $fine, $link, $giornata, $annoEdizioneConferenza, $acronimoConferenza){
            $query= "CALL CREAZIONE_SESSIONE (?,?,?,?,?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('isssssis', $codice, $titolo, $inizio, $fine, $link, $giornata, $annoEdizioneConferenza, $acronimoConferenza);
            $stmt->execute();
        }

        //prende tutte le sessioni
        public function getSessioni(){
            $query = "SELECT * FROM SESSIONE ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        ////prende tutte le sessioni
        public function getPresentazioni(){
            $query = "SELECT * FROM PRESENTAZIONE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce presentazione nella sessione
        public function insertFormazione($codiceSessione, $codicePresentazione){
            $query= "CALL INSERIMENTO_PRESENTAZIONI (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $codiceSessione, $codicePresentazione);
            $stmt->execute();
        }      

        //prende tutti gli speaker
        public function getAllSpeaker(){
            $query = "SELECT * FROM SPEAKER";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //prende tutti i tutorial
        public function getTutorial(){
            $query = "SELECT * FROM TUTORIAL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce come speaker del tutorial
        public function insertDimostrazione($username, $codicePres){
            $query= "CALL ASSOCIAZIONE_SPEAKER (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $username, $codicePres);
            $stmt->execute();
        } 

        //prende tutti i presentatori
        public function getAllPresenter(){
            $query = "SELECT * FROM PRESENTER";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //prende tutti gli articoli
        public function getArticolo(){
            $query = "SELECT * FROM ARTICOLO WHERE StatoSvolgimento=?";
            $stmt = $this->db->prepare($query);
            $stato = "Non coperto";
            $stmt->bind_param('s', $stato);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce come presenter dell'articolo
        public function updatePresenterArticolo($username, $codice){
            $query ="CALL ASSOCIAZIONE_PRESENTER (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $username, $codice);
            $stmt->execute();
            $result = $stmt->get_result();
        
            return $stmt->execute();
        }

        //visualizza le valutazioni date alla presentazione
        public function getValutazioniByPresentazione($presentazione){
            $query = "SELECT * FROM VALUTAZIONE WHERE CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$presentazione);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        ////visualizza tutte le presentazioni valutate
        public function getPresentazioniValutate(){
            $query = "SELECT DISTINCT(CodicePresentazione) FROM VALUTAZIONE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce una nuova valutazione
        public function insertValutazione($presentazione, $username, $voto, $note){
            $query= "CALL INSERIMENTO_VALUTAZIONE (?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('isis', $presentazione, $username, $voto, $note);
            $stmt->execute();
        }

        //inserisce nuovo sponsor
        public function insertSponsor($nome, $logo, $importo){
            $query= "CALL CREAZIONE_SPONSOR (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssi', $nome, $logo, $importo);
            $stmt->execute();
        }

        //visualizza tutti gli sponsor
        public function getSponsor(){
            $query = "SELECT * FROM SPONSOR";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //inserisce relazione sponsorizzazione sposor-conferenza
        public function insertDisposizione($anno, $acronimo, $nomeSp){
            $query= "CALL INSERIMENTO_SPONSORINZZAZIONE (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $anno, $acronimo, $nomeSp);
            $stmt->execute();
        }

        
        //----------------------------------------------------------------------------------------
        //OPERAZIONI PRESENTER

        //inserisce i dati di un presenter !!!!!!!!!!
        public function updateDatiPresenter($username, $curriculum, $foto, $nomeUni, $nomeDipartimento){
            $query ="UPDATE PRESENTER SET Curriculum=? , Foto=?, NomeUni=?, NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $curriculum, $foto, $nomeUni, $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
        
            return $stmt->execute();
        }
        
        //modifica curriculum presenter !!!!!!!!!!!
        public function updateCurriculumPresenter($username, $curriculum){
            $query ="UPDATE PRESENTER SET Curriculum=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $curriculum, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            return $stmt->execute();
        }

        //modifica nome uni presenter !!!!!!!!!!!
        public function updateNomeUniPresenter($username, $nomeUni){
            $query ="UPDATE PRESENTER SET NomeUni=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeUni, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //modifica nome dip presenter !!!!!!!!!!!
        public function updateNomeDipartimentoPresenter($username, $nomeDipartimento){
            $query ="UPDATE PRESENTER SET NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //modifica foto presenter !!!!!!!!!!!
        public function updateFotoPresenter($username, $foto){
            $query ="UPDATE PRESENTER SET Foto=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $foto, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //----------------------------------------------------------------------------------------
        //OPERAZIONI SPEAKER

        //inserisce i dati di uno speaker !!!!!!!!!!
        public function updateDatiSpeaker($username, $curriculum, $foto, $nomeUni, $nomeDipartimento){
            $query ="UPDATE SPEAKER SET Curriculum=? , Foto=?, NomeUni=?, NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $curriculum, $foto, $nomeUni, $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
        
            return $stmt->execute();
        }
        
        //modifica curriculum presenter !!!!!!!!!!!
        public function updateCurriculumSpeaker($username, $curriculum){
            $query ="UPDATE SPEAKER SET Curriculum=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $curriculum, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            return $stmt->execute();
        }

        //modifica nome uni presenter !!!!!!!!!!!
        public function updateNomeUniSpeaker($username, $nomeUni){
            $query ="UPDATE SPEAKER SET NomeUni=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeUni, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //modifica nome dip presenter !!!!!!!!!!!
        public function updateNomeDipartimentoSpeaker($username, $nomeDipartimento){
            $query ="UPDATE SPEAKER SET NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //modifica foto presenter !!!!!!!!!!!
        public function updateFotoSpeaker($username, $foto){
            $query ="UPDATE SPEAKER SET Foto=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $foto, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //inserisce una nuova risorsa !!!!!!!!!!!
        public function insertRisorsa($username, $tutorial, $link, $descrizione){
            $query= "INSERT INTO RISORSA (UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES (?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siss', $username, $tutorial, $link, $descrizione);
            $stmt->execute();
        }

        //modifica link risorsa !!!!!!!!!!!
        public function updateLinkRisorsa($username, $codice, $link){
            $query ="UPDATE RISORSA SET LinkRisorsa=? WHERE UsernameUtente=? AND CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssi', $link, $username, $codice);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //modifica descrizione risorsa !!!!!!!!!!!
        public function updateDescrizioneRisorsa($username, $codice, $descrizione){
            $query ="UPDATE RISORSA SET DescrizioneRisorsa=? WHERE UsernameUtente=? AND CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssi', $descrizione, $username, $codice);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //----------------------------------------------------------------------------------------
        //VARIE

        //ritorna tutti gli speaker
        public function getSpeaker($username){
            $query = "SELECT * FROM SPEAKER WHERE UsernameUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //ritorna tutti i presenter
        public function getPresenter($username){
            $query = "SELECT * FROM PRESENTER WHERE UsernameUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //ritorna tutti gli amministratori
        public function getAmministratore($username){
            $query = "SELECT * FROM AMMINISTRATORE WHERE UsernameUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //ritorna i dati del tutorial dal codice della presentazione
        public function getTutorialByCodice($codicePres){
            $query = "SELECT * FROM TUTORIAL WHERE CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codicePres);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //ritorna i dati dell'articolo dal codice della presentazione
        public function getArticoloByCodice($codicePres){
            $query = "SELECT * FROM ARTICOLO WHERE CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codicePres);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //ritorna le date di una specifica conferenza
        public function getDateConferenza($conf){
            $query = "SELECT Giorno FROM GIORNATA WHERE AcronimoConferenza=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$conf);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //risorna dati sessione dal suo codice
        public function getSessionebyCodice($codiceSess){
            $query = "SELECT * FROM SESSIONE WHERE Codice=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codiceSess);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //risorna i tutorial presentati da uno speaker
        public function getTutorialBySpeaker($username){
            $query = "SELECT * FROM TUTORIAL, DIMOSTRAZIONE WHERE TUTORIAL.CodicePresentazione=DIMOSTRAZIONE.CodicePresentazione AND UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        //ritorna lo speaker che ha presentato un tutorial
        public function getSpeakerByTutorial($codice){
            $query = "SELECT UsernameUtente FROM TUTORIAL, DIMOSTRAZIONE WHERE TUTORIAL.CodicePresentazione=DIMOSTRAZIONE.CodicePresentazione AND DIMOSTRAZIONE.CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codice);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        

    }
?>
