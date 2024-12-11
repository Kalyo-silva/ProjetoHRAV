<?php

class Query{
    private $dbConn;
    private $queryResource;

    private $sql;
    private $values = [];
    private $count;
    
    public function __construct($con) {
        $this->dbConn = $con;
    }

    public function setSQL($sql){
        $this->sql = $sql;
    }

    public function getSQL(){
        return $this->sql;
    }

    public function getCount(){
        return $this->count;
    }

    function setValues($values){
        $this->values = $values;
    }

    public function Open(){
        $this->queryResource = pg_prepare($this->dbConn->getInternalConnection(), '', $this->sql);
        $this->queryResource = pg_execute($this->dbConn->getInternalConnection(), '', $this->values);
        if ($this->queryResource){
            $this->count = pg_num_rows($this->queryResource);
            return true;
        }
        return false;
    }

    public function Next(){
        $row = pg_fetch_assoc($this->queryResource);
        if ($row){
            return $row;
        }
        return false;
    }

    public function DML(){
        $this->queryResource = pg_prepare($this->dbConn->getInternalConnection(), '', $this->sql);
        $this->queryResource = @pg_execute($this->dbConn->getInternalConnection(), '', $this->values);
    
        if ($this->queryResource){
            return true;
        }   
        return false;
    }
}