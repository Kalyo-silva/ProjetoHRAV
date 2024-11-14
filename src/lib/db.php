<?php
class dbConn {
    private $host;
    private $dbname;
    private $user;
    private $password;

    private $status;

    private $connResource;

    public function setStatus($status){
        $this->status = $status;
    }
    
    public function getStatus(){
        return $this->status;
    }

    public function __construct($file, $autoload = true) {
        $config = json_decode(file_get_contents($file), true);

        $this->host = $config['host'];    
        $this->dbname = $config['dbname'];
        $this->user = $config['user'];
        $this->password = $config['password'];

        $this->status = 'Desconectado.';

        if ($autoload){
            $this->connect();
        }
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