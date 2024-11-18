<?php

class router{
    private $ClassName;
    private $Resource;
    private $classInstance;

    public function __construct() {
        $this->route();
    }

    public function getRoute(){
        if (isset($_REQUEST['rt'])){
            return $_REQUEST['rt'];
        }
        return 'index';
    }

    public function getOperation(){
        if (isset($_REQUEST['op'])){
            return $_REQUEST['op'];
        }
        return null;    
    }

    public function route(){
        $rota = $this->getRoute();

        $this->Resource = "controller";
        $this->ClassName = "controller";

        $this->Resource = '../'.$this->Resource . "/" . $this->ClassName . "_" . $rota . ".php";
        $this->ClassName = str_replace("_", "", $this->ClassName) . $rota;
    }

    
    private function instanceClass() {
        require_once $this->Resource;
        if(class_exists($this->ClassName)) {
            if(!isset($this->classInstance)) { 
                if($this->classInstance = new $this->ClassName) {
                    return true;
                }    
            }
        }
        return false;
    }

    public function execute() {
        if($this->instanceClass()) {
            $operation = $this->getOperation();
            if(method_exists($this->classInstance, $operation)) {
                $this->classInstance->{$operation}();
            } else {
                throw new Exception("Operação " . $operation . " inexistente na classe " . $this->ClassName);
            }

        }
    }

}