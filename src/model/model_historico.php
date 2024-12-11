<?php

class ModelHistorico {
    private $sql;
    private $values = [];

    private function setSQL($sql){
        $this->sql = $sql;
    }

    private function setValues($values){
        $this->values = $values;
    }

    private function getSetCodigo(){
        return filter_var($_REQUEST['setor'], FILTER_SANITIZE_NUMBER_INT);
    }

    public function execute(){
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql($this->sql);
        $query->setValues($this->values);
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        return $result;
    }

    public function getFeedback(){
        $sql = "SELECT AVAFEEDBACK, 
                       TO_CHAR(AVADATAHORA, 'DD/MM/YYYY HH:MI') AS AVADATAHORA,
                       SETDESCRICAO
                  FROM TBAVALIACAO
                  JOIN TBSETOR
                 USING (SETCODIGO)
                 WHERE AVAFEEDBACK <> ''";

if ($this->getSetCodigo() != '' && $this->getSetCodigo() != 0) {
            $sql .= ' AND SETCODIGO = $1';

            $this->setValues([$this->getSetCodigo()]);            
        }

        $sql .= "ORDER BY AVADATAHORA DESC";

        $this->setSQL($sql);
    }

    public function getSetores(){
        $this->setSQL("SELECT SETCODIGO, 
                              SETDESCRICAO
                         FROM TBSETOR
                        WHERE SETATIVO = 1");

        return $this->execute();
    } 
}