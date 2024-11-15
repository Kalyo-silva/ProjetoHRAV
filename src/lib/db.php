<?php
class dbConn {
    private $host;
    private $dbname;
    private $user;
    private $password;

    private $status;

    private $connResource;

    public function setHost($host){
        $this->host = $host;
    }

    public function setDbname($dbname){
        $this->dbname = $dbname;
    }

    public function setUser($user){
        $this->user = $user;
    }
    public function setPassword($password){
        $this->password = $password;
    }

    public function setStatus($status){
        $this->status = $status;
    }
    
    public function getStatus(){
        return $this->status;
    }

    public function __construct() {
        $this->setStatus('Desconectado.');
    }

    public function connect(){
        try {
            $this->setStatus('Conectando...');
            if (!isset($this->connResource)){
                $this->connResource = pg_connect("host=$this->host dbname=$this->dbname user=$this->user password=$this->password");
            }

            if ($this->connResource){
                $this->setStatus('Conectado.');
                return true;
            }
        } catch (\Throwable $th) {
            $this->setStatus('Erro ao conetar: '.$th->getMessage());
        }
    }

    public function getInternalConnection(){
        return $this->connResource;
    }

    public function newQuery(){
        require_once './query.php';
        return new Query($this);
    }
}