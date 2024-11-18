<?php

    require_once "db.php";
    require_once "router.php";

class Application{
    private $dbConn;
    private $dbconfig;
    private $router;

    static $instance;

    static function getInstance(){
        return Application::$instance;
    }

    public function getDbConn(){
        return $this->dbConn;
    }

    public function __construct($autoload = True) {
        Application::$instance = $this;

        if (file_exists('../../config.env')){
            $this->dbconfig = json_decode(file_get_contents('../../config.env'), true);
        } else{
            throw new Exception("Arquivo de configuração não encontrado.", 1);   
        };

        if ($autoload) {
            $this->initDb();
        }   

        $this->router = new Router();
    }    

    private function initDb(){
        if (!isset($this->dbConn)){
            $this->dbConn = new dbConn();
            $this->dbConn->setHost($this->dbconfig['host']);    
            $this->dbConn->setDbname($this->dbconfig['dbname']);
            $this->dbConn->setUser($this->dbconfig['user']);
            $this->dbConn->setPassword($this->dbconfig['password']);
        }
        return $this->getDbConn()->connect();
    }



    public function route(){
        $this->router->execute();
    }
}