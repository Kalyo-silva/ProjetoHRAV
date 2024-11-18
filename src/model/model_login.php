<?php

class modelLogin{
    private $usucodigo;
    private $ususenha;

    public function getSessionStatus(){
        session_start();

        if (!isset($_SESSION['usucodigo'])){
          echo false;
        }
        else{
          if (time() - $_SESSION['last_request'] > (10*60)){ //10 min de inatividade 
            echo false;
          }
          else{
            $_SESSION['last_request'] = time();
            echo true;
          }
        }
        
    }

    public function startSession(){
        session_start();
        session_destroy();
        session_start();

        $usucodigo = filter_var($_POST['usucodigo'],FILTER_SANITIZE_NUMBER_INT);

        $_SESSION['usucodigo'] = $usucodigo;
        $_SESSION['last_request'] = time();
    }

    private function setUsucodigo(){
        $this->usucodigo = filter_var($_POST['usucodigo'],FILTER_SANITIZE_NUMBER_INT);
    }
    
    private function setUsusenha(){
        $this->ususenha = filter_var($_POST['ususenha'],FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function validateLogin(){
        $this->setUsucodigo();
        $this->setUsusenha();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select 1 
                          from tbusuario
                         where usucodigo = $1
                           and ususenha = md5($2)
                           and usuativo = 1");
        $query->setValues([$this->usucodigo, $this->ususenha]);
        if ($query->Open()){
            echo json_encode($query->Next());
        }
        else{
            echo null;
        }
        
    }

    public function getUser(){   
        $this->setUsucodigo();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select usucodigo, usunome 
                          from tbusuario
                         where usucodigo = $1
                           and usuativo = 1");
        $query->setValues([$this->usucodigo]);
        if ($query->Open()){
            echo json_encode($query->Next());
        }
        else{
            echo null;
        }
    }
}