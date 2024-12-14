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

    private function getPeriodoIni(){
        if (isset($_REQUEST['dataini']) && $_REQUEST['dataini'] != ''){
            return  filter_var($_REQUEST['dataini'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return date_format(new DateTime('01/01/1900'), 'd/m/Y'); ;
    }

    private function getPeriodoFim(){
        if (isset($_REQUEST['datafim']) && $_REQUEST['datafim'] != ''){
            return filter_var($_REQUEST['datafim'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return date_format(new DateTime('now'), 'd/m/Y');
    }
        

    public function returnSQL(){
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql($this->sql);
        $query->setValues($this->values);
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
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
        
        $this->sql = '';
        $this->values = [];

        return $result;
    }

    public function getFeedback(){
        $this->setValues([$this->getPeriodoIni(), $this->getPeriodoFim()]);

        $sql = "SELECT AVAFEEDBACK, 
                       TO_CHAR(AVADATAHORA, 'DD/MM/YYYY HH:MI') AS AVADATAHORA,
                       SETDESCRICAO
                  FROM TBAVALIACAO
                  JOIN TBSETOR
                 USING (SETCODIGO)
                 WHERE AVADATAHORA BETWEEN $1 AND $2
                   AND AVAFEEDBACK <> ''";

        if ($this->getSetCodigo() != '' && $this->getSetCodigo() != 0) {
            $sql .= ' AND SETCODIGO = $3';

            $this->setValues([$this->getPeriodoIni(), $this->getPeriodoFim(), $this->getSetCodigo()]);            
        }

        $sql .= " ORDER BY TBAVALIACAO.AVADATAHORA DESC";
        
        $this->setSQL($sql);
    }

    public function getNotasPeriodo(){
        
        $this->setValues([$this->getPeriodoIni(), $this->getPeriodoFim()]);
    
        $sql = "SELECT AVARESPOSTA,
                       SETDESCRICAO,
                       TO_CHAR(AVADATAHORA, 'DD/MM/YYYY HH:MI') AS AVADATAHORA
                  FROM TBAVALIACAO
                  JOIN TBSETOR
                 USING (SETCODIGO)
                 WHERE AVADATAHORA BETWEEN $1 AND $2";
                        
        if ($this->getSetCodigo() != '' && $this->getSetCodigo() != 0) {
            $sql .= " AND SETCODIGO = $3";

            $this->setValues([$this->getPeriodoIni(), $this->getPeriodoFim(), $this->getSetCodigo()]);            
        }

        $sql .= " ORDER BY TBAVALIACAO.AVADATAHORA DESC";
        
        $this->setSQL($sql);
    }

    public function getGrafico(){
        $this->setValues([$this->getPeriodoIni(), $this->getPeriodoFim()]);

        $sql = "SELECT SUM(LOW) AS LOW,
                       SUM(MID) AS MID,
                       SUM(HIGH) AS HIGH
                  FROM (
                  SELECT CASE WHEN AVARESPOSTA <= 6 THEN 1 ELSE 0 END AS LOW,
                         CASE WHEN AVARESPOSTA <=8 AND AVARESPOSTA > 6 THEN 1 ELSE 0 END AS MID,
                         CASE WHEN AVARESPOSTA > 8 THEN 1 ELSE 0 END AS HIGH
                    FROM TBAVALIACAO
                   WHERE AVADATAHORA BETWEEN $1 AND $2";
        
        if ($this->getSetCodigo() != '' && $this->getSetCodigo() != 0) {
            $sql .= " AND SETCODIGO = $3";

            $this->setValues([$this->getPeriodoIni(), $this->getPeriodoFim(), $this->getSetCodigo()]);            
        }
        
        $sql .= ") O";

        $this->setSQL($sql);

        echo $this->returnSQL();
    }

    public function getSetores(){
        $this->setSQL("SELECT SETCODIGO, 
                              SETDESCRICAO
                         FROM TBSETOR
                        WHERE SETATIVO = 1");

        return $this->execute();
    } 
}