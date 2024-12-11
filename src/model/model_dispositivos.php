<?php

class modelDispositivos {
    public function getAll() {
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select discodigo,
                               setcodigo,
                               disnome,
                               setdescricao
                          from tbdispositivo
                          join tbsetor
                         using (setcodigo)
                         where disstatus = 1 
                         order by 1");
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }

    public function getTable(){
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select discodigo,
                               disnome as ".'"Dispositivo"'.",
                               case when disstatus = 1 then 'Ativo' else 'Desativado' end as ".'"Situacao"'.",
                               setdescricao as ".'"Setor"'."
                          from tbdispositivo
                          join tbsetor
                         using (setcodigo)
                         order by 3, 1");
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }

    private function getDiscodigo(){
        return filter_var($_REQUEST['discodigo'], FILTER_SANITIZE_NUMBER_INT); 
    }
    private function getDisnome(){
        return filter_var($_REQUEST['disnome'], FILTER_SANITIZE_SPECIAL_CHARS); 
    }
    private function getSetcodigo(){
        return filter_var($_REQUEST['setcodigo'], FILTER_SANITIZE_NUMBER_INT); 
    }


    public function deactivate(){
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("update tbdispositivo set disstatus = case when disstatus = 1 then 0 else 1 end where discodigo = $1");
        $query->setValues([$this->getDiscodigo()]);

        if(!$query->DML()){
            return false;
        }
        return true;
    }
    
    public function insert(){
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("insert into tbdispositivo values((select max(discodigo)+1 from tbdispositivo), 1, $1, $2)");
        $query->setValues([$this->getDisnome(), $this->getSetcodigo()]);

        if(!$query->DML()){
            return false;
        }
        return true;
    }

    public function delete(){
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("delete from tbdispositivo where discodigo = $1");
        $query->setValues([$this->getDiscodigo()]);

        if(!$query->DML()){
            echo false;
            return false;
        }
        echo true;
        return true;
    }

    public function update(){
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("update tbdispositivo set disnome = $2 where discodigo = $1");
        $query->setValues([$this->getDiscodigo(), $this->getDisnome()]);

        if(!$query->DML()){
            echo false;
            return false;
        }
        echo true;
        return true;
    }
};