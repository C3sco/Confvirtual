<?php
    class DatabaseHelper{
        
        private $db;
    
        public function __construct($servername, $username, $password, $dbname, $port){
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }        
        }

        /* Statistiche (visibili da tutti gli utenti nella pagina iniziale) */    

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

        public function getUtente($username){
            $query = "SELECT * FROM UTENTE WHERE Username = ?";
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

        public function getConferenze(){
            $query = "SELECT DISTINCT Nome, Acronimo, AnnoEdizione, Logo FROM conferenze_disponibili";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getConferenzaByNome($nome){
            $query = "SELECT AnnoEdizione, Acronimo FROM CONFERENZA WHERE Nome=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$nome);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getDateConferenza($nomeConf){
            $query = "SELECT Giorno FROM conferenze_disponibili WHERE Nome=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s',$nomeConf);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function insertIscrizione($annoEdizioneConferenza, $acronimoConferenza, $usernameUtente){
            $query= "INSERT INTO ISCRIZIONE(AnnoEdizioneConferenza, AcronimoConferenza, UsernameUtente) VALUES (?,?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sss', $annoEdizioneConferenza, $acronimoConferenza, $usernameUtente);
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

        public function getPresentazioniBySessione($codiceSessione){
            $query = "SELECT * FROM SESSIONE, FORMAZIONE, PRESENTAZIONE WHERE SESSIONE.Codice=CodiceSessione AND PRESENTAZIONE.Codice=CodicePresentazione AND CodiceSessione=?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$codiceSessione);
            $stmt->execute();
            $result = $stmt->get_result();
    
            return $result->fetch_all(MYSQLI_ASSOC);
        }

    }
?>
