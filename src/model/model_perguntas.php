<?php

class modelPerguntas {
    private $percodigo;
    private $perpergunta;
    private $setcodigo;


    public function getTable(){
        $result = [];
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select percodigo,
                               perpergunta as ".'"Pergunta"'.",
                               case when perativo = 1 then 'Ativo' else 'Desativado' end as ".'"Situação"'.",
                               array_to_string((select array_agg(setdescricao)
                                                  from tbperguntasetor
                                                  join tbsetor 
                                                 using (setcodigo)  
                                                 where percodigo = tbpergunta.percodigo), ', ') as ".'"Setores Cadastrados"'."
                          from tbpergunta
                         order by 3, 1");
        $query->open();
        while($row = $query->Next()) {
            array_push($result, $row);
        }
        echo json_encode($result);
    }

    private function getNextPerCodigo(){
        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSql("select max(percodigo)+1 as cod from tbpergunta");
        $query->open();

        return $query->Next();
    }

    public function deactivate(){
        $this->setPercodigo();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("update tbpergunta set perativo = case when perativo = 1 then 0 else 1 end where percodigo = $1");
        $query->setValues([$this->percodigo]);

        if(!$query->DML()){
            return false;
        }
        return true;
    }
    

    private function setPercodigo(){
        $this->percodigo = filter_var($_REQUEST['percodigo'], FILTER_SANITIZE_NUMBER_INT);
    }

    private function setPerpergunta(){
        $this->perpergunta = filter_var($_REQUEST['perpergunta'], FILTER_SANITIZE_SPECIAL_CHARS);
    }

    private function setSetores(){
        $this->setcodigo = $_REQUEST['setcodigo'];

        $this->setcodigo = explode(',', $this->setcodigo);
    }

    public function insert(){
        $this->percodigo = $this->getNextPerCodigo()['cod'];
       
        $this->setPerpergunta();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("insert into tbpergunta values($1, $2, 1)");
        $query->setValues([$this->percodigo, $this->perpergunta]);
        $query->DML();

        $this->setSetores();

        foreach ($this->setcodigo as $setor) {
            $setor = filter_var($setor, FILTER_SANITIZE_NUMBER_INT);
            
            $query->setSQL("insert into tbperguntasetor values($1, $2, 1)");
            $query->setValues([$this->percodigo, $setor]);

            if(!$query->DML()){
                echo false;
            }
            else{
                echo true;
            }
        }        
    }

    public function delete(){
        $this->setPercodigo();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("delete from tbpergunta where percodigo = $1");
        $query->setValues([$this->percodigo]);

        if(!$query->DML()){
            echo false;
        }
        else{
            echo true;
        }
    }

    public function update(){
        $this->setPercodigo();
        $this->setPerpergunta();

        $query = Application::getInstance()->getDbConn()->newQuery();
        $query->setSQL("update tbpergunta set perpergunta = $2 where percodigo = $1");
        $query->setValues([$this->percodigo, $this->perpergunta]);

        if(!$query->DML()){
            echo false;
        }
        else{
            echo true;
        }
    }        
}