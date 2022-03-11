<?php
    class DatabaseHelper{
        
        private $db;
    
        public function __construct($servername, $username, $password, $dbname, $port){
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }        
        }

        //STATISTICHE PAGINA INIZIALE

        public function getNumConferenze(){
            $query = "SELECT COUNT(*) as NumConf FROM CONFERENZA";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getNumConferenzeAttive(){
            $attiva = "Attiva";
            $query = "SELECT COUNT(*) as NumConfAtt FROM CONFERENZA WHERE Svolgimento=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $attiva);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getNumUtenti(){
            $query = "SELECT COUNT(*) as NumUtenti FROM UTENTE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } 

        public function avgVotoPresenter(){
            $query = "SELECT ARTICOLO.UsernameUtente, AVG(Voto) AS Media FROM VALUTAZIONE, ARTICOLO WHERE ARTICOLO.CodicePresentazione=VALUTAZIONE.CodicePresentazione GROUP BY ARTICOLO.UsernameUtente ORDER BY Media DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } 

        public function avgVotoSpeaker(){
            $query = "SELECT DIMOSTRAZIONE.UsernameUtente, AVG(Voto) AS Media FROM VALUTAZIONE, DIMOSTRAZIONE WHERE DIMOSTRAZIONE.CodicePresentazione=VALUTAZIONE.CodicePresentazione GROUP BY DIMOSTRAZIONE.UsernameUtente ORDER BY Media DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } 

        //OPERAZIONI UTENTI GENERICI

        public function getUtente($username){
            $query = "SELECT * FROM UTENTE WHERE Username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getSpeaker($username){
            $query = "SELECT * FROM SPEAKER WHERE UsernameUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getAllSpeaker(){
            $query = "SELECT * FROM SPEAKER";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getTutorial(){
            $query = "SELECT * FROM TUTORIAL";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insertDimostrazione($username, $codicePres){
            $query= "INSERT INTO DIMOSTRAZIONE (UsernameUtente, CodicePresentazione) VALUES (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $username, $codicePres);
            $stmt->execute();
        } 

        public function getAllPresenter(){
            $query = "SELECT * FROM PRESENTER";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getArticolo(){
            $query = "SELECT * FROM ARTICOLO WHERE StatoSvolgimento=?";
            $stmt = $this->db->prepare($query);
            $stato = "Non coperto";
            $stmt->bind_param('s', $stato);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function updatePresenterArticolo($username, $codice){
            $query ="UPDATE ARTICOLO SET UsernameUtente=? WHERE CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('si', $username, $codice);
            $stmt->execute();
            $result = $stmt->get_result();
        
            return $stmt->execute();
        }

        public function getPresenter($username){
            $query = "SELECT * FROM PRESENTER WHERE UsernameUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getAmministratore($username){
            $query = "SELECT * FROM AMMINISTRATORE WHERE UsernameUtente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insertUser($username, $password, $nome, $cognome, $datanascita, $luogonascita){
            $query= "INSERT INTO UTENTE(Username, Passwordd, Nome, Cognome, DataNascita, LuogoNascita) VALUES (?,?,?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssssss', $username, $password, $nome, $cognome, $datanascita, $luogonascita);
            $stmt->execute();
        }

        public function insertValutazione($presentazione, $username, $voto, $note){
            $query= "INSERT INTO VALUTAZIONE (CodicePresentazione, UsernameUtente, Voto, Note) VALUES (?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('isis', $presentazione, $username, $voto, $note);
            $stmt->execute();
        }

        public function insertConferenza($anno, $acronimo, $nome, $logo){
            $query= "INSERT INTO CONFERENZA (AnnoEdizione, Acronimo, Nome, Logo) VALUES (?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('isss', $anno, $acronimo, $nome, $logo);
            $stmt->execute();
        }

        public function insertCreazioneConf($anno, $acronimo, $username){
            $query= "INSERT INTO CREAZIONE (AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $anno, $acronimo, $username);
            $stmt->execute();
        }  

        public function insertDataConferenza($acronimo, $anno, $data){
            $query= "INSERT INTO GIORNATA (AnnoEdizioneConferenza, AcronimoConferenza, Giorno) VALUES (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $anno, $acronimo, $data);
            $stmt->execute();
        }

        //OPERAZIONI PRESENTER

        public function updateDatiPresenter($username, $curriculum, $foto, $nomeUni, $nomeDipartimento){
            $query ="UPDATE PRESENTER SET Curriculum=? , Foto=?, NomeUni=?, NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $curriculum, $foto, $nomeUni, $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
        
            return $stmt->execute();
        }
        
        public function updateCurriculumPresenter($username, $curriculum){
            $query ="UPDATE PRESENTER SET Curriculum=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $curriculum, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            return $stmt->execute();
        }

        public function updateNomeUniPresenter($username, $nomeUni){
            $query ="UPDATE PRESENTER SET NomeUni=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeUni, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        public function updateNomeDipartimentoPresenter($username, $nomeDipartimento){
            $query ="UPDATE PRESENTER SET NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        public function updateFotoPresenter($username, $foto){
            $query ="UPDATE PRESENTER SET Foto=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $foto, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //OPERAZIONI SPEAKER

        public function updateDatiSpeaker($username, $curriculum, $foto, $nomeUni, $nomeDipartimento){
            $query ="UPDATE SPEAKER SET Curriculum=? , Foto=?, NomeUni=?, NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssss', $curriculum, $foto, $nomeUni, $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
        
            return $stmt->execute();
        }
        
        public function updateCurriculumSpeaker($username, $curriculum){
            $query ="UPDATE SPEAKER SET Curriculum=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $curriculum, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            return $stmt->execute();
        }

        public function updateNomeUniSpeaker($username, $nomeUni){
            $query ="UPDATE SPEAKER SET NomeUni=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeUni, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        public function updateNomeDipartimentoSpeaker($username, $nomeDipartimento){
            $query ="UPDATE SPEAKER SET NomeDipartimento=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $nomeDipartimento, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        public function updateFotoSpeaker($username, $foto){
            $query ="UPDATE SPEAKER SET Foto=? WHERE UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $foto, $username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        public function insertRisorsa($username, $tutorial, $link, $descrizione){
            $query= "INSERT INTO RISORSA (UsernameUtente,CodicePresentazione,LinkRisorsa,DescrizioneRisorsa) VALUES (?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siss', $username, $tutorial, $link, $descrizione);
            $stmt->execute();
        }

        public function updateLinkRisorsa($username, $codice, $link){
            $query ="UPDATE RISORSA SET LinkRisorsa=? WHERE UsernameUtente=? AND CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssi', $link, $username, $codice);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        public function updateDescrizioneRisorsa($username, $codice, $descrizione){
            $query ="UPDATE RISORSA SET DescrizioneRisorsa=? WHERE UsernameUtente=? AND CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssi', $descrizione, $username, $codice);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $stmt->execute();
        }

        //VARIE

        public function getConferenze(){
            $query = "SELECT DISTINCT Nome, Acronimo, AnnoEdizione, Logo, TotaleSponsorizzazioni FROM CONFERENZA WHERE Svolgimento=?";
            $stmt = $this->db->prepare($query);
            $attiva = "Attiva";
            $stmt->bind_param('s',$attiva);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getConferenzaByNome($nome){
            $query = "SELECT AnnoEdizione, Acronimo, Nome FROM CONFERENZA WHERE Nome=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$nome);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getDateConferenza($conf){
            $query = "SELECT Giorno FROM GIORNATA WHERE AcronimoConferenza=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$conf);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insertIscrizione($annoEdizioneConferenza, $acronimoConferenza, $usernameUtente){
            $query= "CALL REGISTRAZIONE_CONFERENZA(?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $annoEdizioneConferenza, $acronimoConferenza, $usernameUtente);
            $stmt->execute();
        }

        public function getSessionibyConferenza($acronimoConf){
            $query = "SELECT * FROM SESSIONE WHERE AcronimoConferenza=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$acronimoConf);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getSessionebyCodice($codiceSess){
            $query = "SELECT * FROM SESSIONE WHERE Codice=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codiceSess);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getSessioni(){
            $query = "SELECT * FROM SESSIONE ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getPresentazioni(){
            $query = "SELECT * FROM PRESENTAZIONE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insertFormazione($codiceSessione, $codicePresentazione){
            $query= "INSERT INTO FORMAZIONE (CodiceSessione, CodicePresentazione) VALUES (?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $codiceSessione, $codicePresentazione);
            $stmt->execute();
        }        

        public function getPresentazioniBySessione($codiceSessione){
            $query = "SELECT * FROM SESSIONE, FORMAZIONE, PRESENTAZIONE WHERE SESSIONE.Codice=CodiceSessione AND PRESENTAZIONE.Codice=CodicePresentazione AND CodiceSessione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codiceSessione);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getGiornate($conferenza){
            $query = "SELECT Giorno FROM GIORNATA WHERE AcronimoConferenza=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$conferenza);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insertSessione($codice, $titolo, $inizio, $fine, $link, $giornata, $annoEdizioneConferenza, $acronimoConferenza){
            $query= "INSERT INTO SESSIONE (Codice, Titolo, Inizio, Fine, Link, GiornoGiornata, AnnoEdizioneConferenza, AcronimoConferenza) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('isssssis', $codice, $titolo, $inizio, $fine, $link, $giornata, $annoEdizioneConferenza, $acronimoConferenza);
            $stmt->execute();
        }

        public function insertSponsor($nome, $logo, $importo){
            $query= "INSERT INTO SPONSOR (Nome, Logo, Importo) VALUES (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssi', $nome, $logo, $importo);
            $stmt->execute();
        }

        public function insertDisposizione($anno, $acronimo, $nomeSp){
            $query= "INSERT INTO DISPOSIZIONE (AnnoEdizioneConferenza, AcronimoConferenza, NomeSponsor) VALUES (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iss', $anno, $acronimo, $nomeSp);
            $stmt->execute();
        }

        public function getSponsor(){
            $query = "SELECT * FROM SPONSOR";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getPresentazioniValutate(){
            $query = "SELECT DISTINCT(CodicePresentazione) FROM VALUTAZIONE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getValutazioniByPresentazione($presentazione){
            $query = "SELECT * FROM VALUTAZIONE WHERE CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$presentazione);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insertAmministratore($username){
            $query= "INSERT INTO AMMINISTRATORE (UsernameUtente) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
        }

        public function insertSpeaker($username){
            $query= "INSERT INTO SPEAKER (UsernameUtente) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
        }

        public function insertPresenter($username){
            $query= "INSERT INTO PRESENTER (UsernameUtente) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
        }

        public function getTutorialByCodice($codicePres){
            $query = "SELECT * FROM TUTORIAL WHERE CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codicePres);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getArticoloByCodice($codicePres){
            $query = "SELECT * FROM ARTICOLO WHERE CodicePresentazione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codicePres);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getTutorialBySpeaker($username){
            $query = "SELECT * FROM TUTORIAL, DIMOSTRAZIONE WHERE TUTORIAL.CodicePresentazione=DIMOSTRAZIONE.CodicePresentazione AND UsernameUtente=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$username);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

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
