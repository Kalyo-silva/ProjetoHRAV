<?php

class modelSetor{
    private $setcodigo;
    private $setDescricao;

    public function getTable(){
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select setcodigo,
                               setdescricao as ".'"Descrição do Setor"'.",
                               case when setativo = 1 then 'Ativo' else 'Desativado' end as ".'"Situação"'."
                          from tbsetor 
                         order by setativo desc, setcodigo");
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }

    private function setSetcodigo(){
        $this->setcodigo = filter_var($_POST['setcodigo'], FILTER_SANITIZE_NUMBER_INT);
    }

    private function setSetDescricao(){
        $this->setDescricao = filter_var($_POST['setdescricao'], FILTER_SANITIZE_SPECIAL_CHARS);
    }


    public function deactivate(){
        $this->setSetcodigo();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("update tbsetor set setativo = case when setativo = 1 then 0 else 1 end where setcodigo = $1");
        $query->setValues([$this->setcodigo]);

        if(!$query->DML()){
            return false;
        }
        return true;
    }
    
    public function insert(){
        $this->setSetDescricao();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("insert into tbsetor values((select max(setcodigo)+1 from tbsetor), $1, 1)");
        $query->setValues([$this->setDescricao]);

        if(!$query->DML()){
            echo false;
        }
        else{
            echo true;
        }
    }

    public function delete(){
        $this->setSetcodigo();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("delete from tbsetor where setcodigo = $1");
        $query->setValues([$this->setcodigo]);

        if(!$query->DML()){
            echo false;
        }
        else{
            echo true;
        }
    }

    public function update(){
        $this->setSetcodigo();
        $this->setSetDescricao();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("update tbsetor set setdescricao = $2 where setcodigo = $1");
        $query->setValues([$this->setcodigo, $this->setDescricao]);

        if(!$query->DML()){
            echo false;
        }
        else{
            echo true;
        }
    }    
}