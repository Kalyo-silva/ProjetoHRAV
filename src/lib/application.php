<?php

    require_once "db.php";
    require_once "router.php";

class Application{
    private $dbConn;
    private $router;

    static $instance;

    static function getInstance(){
        return Application::$instance;
    }

    public function getDbConn(){
        return $this->dbConn;
    }

    public function __construct() {
        Application::$instance = $this;

        if (file_exists('../../config.env')){
            $this->dbConn = new dbConn('../../config.env');    
        } else{
            throw new Exception("Arquivo de configuração não encontrado.", 1);   
        };

        $this->router = new Router();
    }    

    public function route(){
        $this->router->execute();
    }
}